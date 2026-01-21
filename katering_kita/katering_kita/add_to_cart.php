<?php
session_start();
include "config.php";

if (!isset($_POST['id_menu'])) exit;

$id_menu = intval($_POST['id_menu']);

$q = mysqli_query($conn, "
    SELECT id_menu, nama_menu, harga, foto
    FROM menu
    WHERE id_menu = $id_menu AND status = 1
");

$menu = mysqli_fetch_assoc($q);
if (!$menu) exit;

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

if (isset($_SESSION['keranjang'][$id_menu])) {
    $_SESSION['keranjang'][$id_menu]['qty']++;
} else {
    $_SESSION['keranjang'][$id_menu] = [
        'nama_menu' => $menu['nama_menu'],
        'harga' => $menu['harga'],
        'gambar' => $menu['foto'],
        'qty' => 1
    ];
}

echo "OK";
