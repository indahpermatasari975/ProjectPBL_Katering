<?php
session_start();
include "config.php";

/* ================= CEK METHOD ================= */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: register_user.php");
    exit;
}

/* ================= AMBIL & VALIDASI DATA ================= */
$nama     = trim($_POST['nama']);
$username = trim($_POST['username']);
$password = $_POST['password'];

if ($nama == '' || $username == '' || $password == '') {
    $_SESSION['msg'] = "Semua field wajib diisi!";
    header("Location: register_user.php");
    exit;
}

/* ================= CEK USERNAME ================= */
$cek = mysqli_prepare($conn, "SELECT id_user FROM users WHERE username = ?");
mysqli_stmt_bind_param($cek, "s", $username);
mysqli_stmt_execute($cek);
$result = mysqli_stmt_get_result($cek);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['msg'] = "Username sudah digunakan!";
    header("Location: register_user.php");
    exit;
}

/* ================= SIMPAN USER ================= */
// Role diset sebagai 'customer' atau 'pelanggan' untuk membedakan dengan admin
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$role = "customer"; 

// Pastikan kolom 'dibuat_pada' ada di tabel, jika tidak ada hapus bagian itu. 
// Mengacu pada proses_register.php yang lama, sepertinya menggunakan NOW()
// Jika error, cek field database. Asumsi field sama dengan admin.
$stmt = mysqli_prepare($conn, "
    INSERT INTO users (nama, username, password, role)
    VALUES (?, ?, ?, ?)
");
mysqli_stmt_bind_param($stmt, "ssss", $nama, $username, $password_hash, $role);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['msg'] = "Registrasi berhasil! Silakan login.";
    header("Location: login_user.php");
    exit;
} else {
    $_SESSION['msg'] = "Registrasi gagal! Silakan coba lagi.";
    header("Location: register_user.php");
    exit;
}
