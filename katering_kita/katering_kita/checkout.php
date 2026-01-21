<?php
session_start();
include "config.php";

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

/* ===============================
   VALIDASI KERANJANG
   =============================== */
if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <title>Keranjang Kosong</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: 'Keranjang Kosong!',
                text: 'Silakan pilih menu terlebih dahulu.',
                icon: 'warning',
                confirmButtonColor: '#ffc107',
                confirmButtonText: 'Oke'
            }).then(() => {
                window.location = 'index.php';
            });
        </script>
    </body>
    </html>";
    exit;
}

$keranjang = $_SESSION['keranjang'];

/* ===============================
   AMBIL METODE PEMBAYARAN
   =============================== */
$q_metode = mysqli_query($conn, "
    SELECT nama_metode 
    FROM metode_pembayaran 
    WHERE status = 1
    ORDER BY nama_metode ASC
");

/* ===============================
   PROSES FORM CHECKOUT
   =============================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['checkout'] = [
        'nama'           => $_POST['nama'],
        'telepon'        => $_POST['telepon'],
        'email'          => $_POST['email'],
        'alamat'         => $_POST['alamat'],
        'tanggal_acara'  => $_POST['tanggal_acara'],
        'pembayaran'     => $_POST['pembayaran']
    ];

    header("Location: struk.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout – Katering Kita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">Katering Kita</a>
    </div>
</nav>

<div class="container" style="margin-top:90px; margin-bottom:50px;">
    <div class="row">

        <!-- FORM CHECKOUT -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow p-4">
                <h4 class="text-center mb-3">Data Diri & Pembayaran</h4>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor WhatsApp</label>
                        <input type="text" name="telepon" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Pengiriman</label>
                        <textarea name="alamat" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Acara</label>
                        <input type="date" name="tanggal_acara" class="form-control" required>
                    </div>

                    <!-- METODE PEMBAYARAN DINAMIS -->
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="pembayaran" class="form-select" required>
                            <option value="" selected disabled>-- Pilih Metode --</option>
                            <?php while ($m = mysqli_fetch_assoc($q_metode)) : ?>
                                <option value="<?= htmlspecialchars($m['nama_metode']) ?>">
                                    <?= htmlspecialchars($m['nama_metode']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        Lanjut ke Struk
                    </button>
                </form>
            </div>
        </div>

        <!-- RINGKASAN KERANJANG -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow p-3">
                <h5 class="text-center mb-3">Ringkasan Pesanan</h5>

                <table class="table table-bordered table-sm">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Menu</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($keranjang as $item):
                            $subtotal = $item['harga'] * $item['qty'];
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nama_menu']) ?></td>
                            <td class="text-center"><?= $item['qty'] ?></td>
                            <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="fw-bold">
                            <td colspan="2" class="text-end">Total</td>
                            <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<footer class="bg-dark text-white text-center py-3">
    &copy; <?= date('Y') ?> Katering Kita
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
