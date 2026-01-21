<?php
session_start();
include "config.php";

// Jika tombol "Kembali ke Menu Katering" diklik, reset session checkout & keranjang
if (isset($_GET['reset']) && $_GET['reset'] == 1) {
    unset($_SESSION['checkout']);
    unset($_SESSION['keranjang']);
    // Redirect ke URL spesifik
    header("Location: http://localhost/katering_kita/index.php");
    exit;
}

// Jika session checkout atau keranjang tidak ada, arahkan langsung ke URL spesifik
if (!isset($_SESSION['checkout']) || !isset($_SESSION['keranjang'])) {
    header("Location: http://localhost/katering_kita/index.php");
    exit;
}

$checkout  = $_SESSION['checkout'];
$keranjang = $_SESSION['keranjang'];

// Hitung total
$total = 0;
foreach ($keranjang as $item) {
    $total += $item['harga'] * $item['qty'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Terima Kasih – Katering Kita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container" style="margin-top:100px; max-width:900px;">

    <div class="card shadow p-4 text-center">

        <h2 class="text-success mb-3">Terima kasih atas pesanan Anda 🙏</h2>
        <p class="mb-4">Pesanan Anda sudah kami terima dan akan segera kami proses.</p>

        <hr>

        <h4 class="mt-4 mb-3">Detail Pesanan</h4>

        <div class="row text-start">
            <div class="col-md-6">
                <p><strong>Nama:</strong> <?= htmlspecialchars($checkout['nama']); ?></p>
                <p><strong>WA:</strong> <?= htmlspecialchars($checkout['telepon']); ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($checkout['email']); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Alamat:</strong> <?= htmlspecialchars($checkout['alamat']); ?></p>
                <p><strong>Tanggal Acara:</strong> <?= htmlspecialchars($checkout['tanggal_acara']); ?></p>
                <p><strong>Metode Pembayaran:</strong> <?= htmlspecialchars($checkout['pembayaran']); ?></p>
            </div>
        </div>

        <table class="table table-bordered mt-3">
            <thead class="table-light text-center">
                <tr>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($keranjang as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nama_menu']); ?></td>
                    <td>Rp <?= number_format($item['harga'],0,',','.'); ?></td>
                    <td class="text-center"><?= $item['qty']; ?></td>
                    <td>Rp <?= number_format($item['harga'] * $item['qty'],0,',','.'); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total</td>
                    <td class="fw-bold">Rp <?= number_format($total,0,',','.'); ?></td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4 d-flex justify-content-center gap-3">
            <!-- Tombol reset session dan redirect ke URL spesifik -->
            <a href="terimakasih.php?reset=1" class="btn btn-primary">Kembali ke Menu Katering</a>
            <a href="checkout.php" class="btn btn-outline-secondary">Pesan Lagi</a>
        </div>

    </div>
</div>

</body>
</html>
