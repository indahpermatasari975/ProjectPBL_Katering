<?php
session_start();
include "config.php";

/* ================================
   CEK SESSION
   ================================ */
if (!isset($_SESSION['checkout']) || !isset($_SESSION['keranjang'])) {
    header("Location: checkout.php");
    exit;
}

$checkout  = $_SESSION['checkout'];
$keranjang = $_SESSION['keranjang'];

/* ================================
   HITUNG TOTAL
   ================================ */
$total = 0;
foreach ($keranjang as $item) {
    $total += $item['harga'] * $item['qty'];
}

/* ================================
   SIMPAN DATA KE TABEL PESANAN
   ================================ */
$stmt = $conn->prepare("INSERT INTO pesanan 
    (nama, telepon, email, alamat, tanggal_acara, metode_pembayaran, total_harga, status_pesanan)
    VALUES (?, ?, ?, ?, ?, ?, ?, 'menunggu_pembayaran')");
$stmt->bind_param(
    "ssssssd", 
    $checkout['nama'], 
    $checkout['telepon'], 
    $checkout['email'], 
    $checkout['alamat'], 
    $checkout['tanggal_acara'], 
    $checkout['pembayaran'], 
    $total
);
$stmt->execute();
$pesanan_id = $stmt->insert_id;
$stmt->close();

/* ================================
   PROSES UPLOAD BUKTI TRANSFER
   ================================ */
if (isset($_POST['upload_bukti']) && isset($_FILES['bukti_transfer'])) {

    $file = $_FILES['bukti_transfer'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png'];

    if (!in_array($ext, $allowed)) {
        $upload_error = 'Format file harus JPG atau PNG';
    } else {
        $namaFile = 'bukti_' . time() . '.' . $ext;
        $tujuan = 'uploads/bukti/' . $namaFile;

        if (move_uploaded_file($file['tmp_name'], $tujuan)) {
            // Update status pembayaran menjadi sudah_bayar
            $stmt = $conn->prepare("UPDATE pesanan SET status_pesanan='sudah_bayar' WHERE id_pesanan=?");
            $stmt->bind_param("i", $pesanan_id);
            $stmt->execute();
            $stmt->close();

            // Redirect langsung ke halaman terimakasih
            header("Location: terimakasih.php");
            exit;
        } else {
            $upload_error = 'Upload gagal';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pesanan – Katering Kita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .struk-card {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            background: #f8f9fa;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container" style="margin-top:80px; margin-bottom:50px;">
    <h2 class="text-center mb-4">Struk Pesanan</h2>

    <div class="struk-card mx-auto" style="max-width:900px;">

        <!-- DATA DIRI -->
        <h4>Data Pemesan</h4>
        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Nama:</strong> <?= htmlspecialchars($checkout['nama']); ?></p>
                <p><strong>WA:</strong> <?= htmlspecialchars($checkout['telepon']); ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($checkout['email']); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Alamat:</strong> <?= htmlspecialchars($checkout['alamat']); ?></p>
                <p><strong>Tanggal Acara:</strong> <?= htmlspecialchars($checkout['tanggal_acara']); ?></p>
                <p><strong>Pembayaran:</strong> <?= htmlspecialchars($checkout['pembayaran']); ?></p>
            </div>
        </div>

        <!-- RINCIAN PESANAN -->
        <h4>Rincian Pesanan</h4>
        <table class="table table-bordered">
            <thead class="table-dark text-center">
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

        <!-- QR + UPLOAD -->
        <?php if ($checkout['pembayaran'] !== 'Cash on Delivery'): ?>
            <div class="text-center mt-4">
                <h5>Scan QR untuk Pembayaran</h5>

                <img src="assets/img/qr-payment.png"
                     style="max-width:220px; border:1px solid #ccc; border-radius:12px; padding:10px; background:#fff;">

                <p class="mt-2 text-muted">
                    Metode: <strong><?= htmlspecialchars($checkout['pembayaran']); ?></strong>
                </p>

                <form method="POST" enctype="multipart/form-data" class="mt-3">
                    <input type="file" name="bukti_transfer"
                           class="form-control mb-2"
                           accept="image/*" required>

                    <button type="submit" name="upload_bukti"
                            class="btn btn-primary">
                        Upload Bukti Transfer
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div class="alert alert-success text-center mt-4">
                <h4 class="alert-heading">Pesanan Berhasil!</h4>
                <p>Pembayaran dilakukan saat pesanan diterima (COD).</p>
                <hr>
            </div>

            <div class="text-center mt-4">
                <a href="terimakasih.php" class="btn btn-success btn-lg">
                    Selesai & Kembali ke Menu
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (isset($upload_error)): ?>
<script>
    Swal.fire({
        title: 'Gagal!',
        text: '<?= $upload_error ?>',
        icon: 'error',
        confirmButtonColor: '#d33',
        confirmButtonText: 'Coba Lagi'
    });
</script>
<?php endif; ?>
</body>
</html>
