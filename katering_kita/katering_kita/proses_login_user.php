<?php
session_start();
include "config.php";

$username = $_POST['username'];
$password = $_POST['password'];

// Ambil data user berdasarkan username dan role customer
// Kita tidak membatasi role di query ini, tapi nanti kita cek role-nya atau set sessionnya.
// Idealnya admin login di login.php, user di login_user.php
$q = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$data = mysqli_fetch_assoc($q);

if ($data) {
    // Cek password
    if (password_verify($password, $data['password'])) {

        // Cek apakah dia customer atau admin
        // Jika admin mencoba login disini, kita bisa tolak atau biarkan saja tapi redirect kemana?
        // Sesuai request: login user untuk belanja.
        
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role']; // customer / pelanggan

        // Redirect ke halaman belanja
        header("Location: index.php");
        exit;

    } else {
        header("Location: login_user.php?error=Password salah");
        exit;
    }
} else {
    header("Location: login_user.php?error=Username tidak ditemukan");
    exit;
}
