<?php
session_start();
include "config.php";

$username = $_POST['username'];
$password = $_POST['password'];

// Ambil data user berdasarkan username
$q = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$data = mysqli_fetch_assoc($q);

// Jika username ditemukan
if ($data) {

    // Cek password menggunakan password_verify
    if (password_verify($password, $data['password'])) {

        // Set session user
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];

        // Arahkan sesuai role
        if ($data['role'] == 'pelanggan') {
            header("Location: index.php");
        } else {
            header("Location: dashboard/index.php");
        }
        exit;

    } else {
        // Password salah
        header("Location: login.php?error=Password salah");
        exit;
    }

} else {
    // Username tidak ditemukan
    header("Location: login.php?error=Username tidak ditemukan");
    exit;
}
