<?php
include "config.php";

/* ================= CEK ID MENU ================= */
if (!isset($_GET['id_menu'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id_menu']);

/* ================= AMBIL DATA MENU ================= */
$q = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu = $id AND status = 1");
$menu = mysqli_fetch_assoc($q);

if (!$menu) {
    echo "Menu tidak ditemukan!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemesanan – <?= $menu['nama_menu']; ?></title>
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

<!-- ================= KONTEN ================= -->
<section class="py-5">
    <div class="container">

        <div class="row">

            <!-- KIRI: DETAIL MENU -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <img src="uploads/<?= $menu['gambar']; ?>"
                         class="card-img-top"
                         style="height:300px;object-fit:cover">

                    <div class="card-body text-center">
                        <h3><?= $menu['nama_menu']; ?></h3>
                        <p class="text-muted"><?= nl2br($menu['deskripsi']); ?></p>
                        <h5 class="fw-bold text-success">
                            Rp <?= number_format($menu['harga'], 0, ',', '.'); ?> / porsi
                        </h5>
                    </div>
                </div>
            </div>

            <!-- KANAN: FORM PEMESANAN -->
            <div class="col-lg-6">
                <div class="card p-4 shadow-sm">
                    <h4 class="text-center mb-3">Form Pemesanan</h4>

                    <form action="proses_pemesanan.php" method="POST">

                        <input type="hidden" name="id_menu" value="<?= $menu['id_menu']; ?>">

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_pemesan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="telepon" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Pengantaran</label>
                            <input type="date" name="tanggal_pesan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Porsi</label>
                            <input type="number" name="jumlah" min="1" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea name="catatan" class="form-control" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Pesan Sekarang
                        </button>
                    </form>
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
