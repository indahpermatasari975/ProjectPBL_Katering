<?php
session_start();
include "config.php";

/* ================= CEK METHOD ================= */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

/* ================= AMBIL DATA FORM ================= */
$id_menu        = intval($_POST['id_menu']);
$nama_pemesan   = mysqli_real_escape_string($conn, $_POST['nama_pemesan']);
$telepon        = mysqli_real_escape_string($conn, $_POST['telepon']);
$tanggal_pesan  = $_POST['tanggal_pesan'];
$jumlah         = intval($_POST['jumlah']);
$catatan        = mysqli_real_escape_string($conn, $_POST['catatan'] ?? '');
$id_user        = $_SESSION['id_user'] ?? NULL;

/* ================= AMBIL DATA MENU ================= */
$q = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu = $id_menu AND status = 1");
$menu = mysqli_fetch_assoc($q);

if (!$menu) {
    die("Menu tidak ditemukan!");
}

/* ================= HITUNG HARGA ================= */
$harga     = $menu['harga'];
$subtotal  = $harga * $jumlah;
$total     = $subtotal;

/* ================= SIMPAN KE TABEL PESANAN ================= */
$queryPesanan = "
    INSERT INTO pesanan 
    (id_user, nama_pemesan, telepon, tanggal_pesan, catatan, status, total_harga)
    VALUES
    ('$id_user', '$nama_pemesan', '$telepon', '$tanggal_pesan', '$catatan', 'Pending', '$total')
";

if (mysqli_query($conn, $queryPesanan)) {

    $id_pesanan = mysqli_insert_id($conn);

    /* ================= SIMPAN DETAIL PESANAN ================= */
    $queryDetail = "
        INSERT INTO detail_pesanan
        (id_pesanan, id_menu, jumlah, harga, subtotal)
        VALUES
        ('$id_pesanan', '$id_menu', '$jumlah', '$harga', '$subtotal')
    ";

    mysqli_query($conn, $queryDetail);

    /* ================= REDIRECT ================= */
    header("Location: sukses.php?id_pesanan=" . $id_pesanan);
    exit;

} else {
    echo "Gagal menyimpan pesanan: " . mysqli_error($conn);
}
