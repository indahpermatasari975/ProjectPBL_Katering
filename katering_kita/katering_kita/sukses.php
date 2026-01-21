<?php
include "config.php";

/* ================= CEK ID PESANAN ================= */
if (!isset($_GET['id_pesanan'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id_pesanan']);

/* ================= AMBIL DATA PESANAN ================= */
$q = mysqli_query($conn, "
    SELECT p.*, m.nama_menu, d.jumlah
    FROM pesanan p
    JOIN detail_pesanan d ON p.id_pesanan = d.id_pesanan
    JOIN menu m ON d.id_menu = m.id_menu
    WHERE p.id_pesanan = $id
");

$data = mysqli_fetch_assoc($q);

if (!$data) {
    echo "Data pesanan tidak ditemukan!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemesanan Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Menu Katering</a>
    </div>
</nav>

<div style="margin-top:80px"></div>

<!-- ================= KONTEN SUKSES ================= -->
<section class="py-5">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-7">

                <div class="card shadow p-4 text-center">

                    <div class="mb-3">
                        <span style="font-size:60px">✅</span>
                    </div>

                    <h3 class="mb-3">Pemesanan Berhasil!</h3>

                    <p class="lead">
                        Terima kasih, <strong><?= $data['nama_pemesan']; ?></strong>.
                    </p>

                    <div class="text-start px-3">
                        <p><strong>Menu:</strong> <?= $data['nama_menu']; ?></p>
                        <p><strong>Jumlah Porsi:</strong> <?= $data['jumlah']; ?></p>
                        <p><strong>Tanggal Pengantaran:</strong> <?= $data['tanggal_pesan']; ?></p>
                        <p><strong>Status Pesanan:</strong>
                            <span class="badge bg-warning text-dark">
                                <?= $data['status']; ?>
                            </span>
                        </p>
                        <p><strong>Total Harga:</strong>
                            Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?>
                        </p>
                    </div>

                    <hr>

                    <a href="index.php" class="btn btn-success w-100 mt-3">
                        Kembali ke Menu Katering
                    </a>
                </div>

            </div>
        </div>

    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-dark text-white text-center py-3">
    &copy; <?= date('Y'); ?> Menu Katering
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
