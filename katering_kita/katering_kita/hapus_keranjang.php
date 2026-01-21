<?php
session_start();

// Pastikan ada id_menu
if (!isset($_GET['id_menu'])) {
    header("Location: keranjang.php");
    exit;
}

$id_menu = intval($_GET['id_menu']);

// Cek apakah keranjang ada
if (isset($_SESSION['keranjang'][$id_menu])) {
    unset($_SESSION['keranjang'][$id_menu]); // Hapus item dari keranjang
}

// Redirect kembali ke halaman keranjang
header("Location: keranjang.php");
exit;
