<?php
session_start();
include "config.php";

$session_id = session_id(); // id unik untuk tiap user

// Tambah atau update qty jika form dikirim
if (isset($_POST['update_qty'])) {
    foreach ($_POST['qty'] as $id_menu => $jumlah) {
        $jumlah = intval($jumlah);
        if ($jumlah <= 0) {
            unset($_SESSION['keranjang'][$id_menu]); // hapus session
            // hapus dari DB
            mysqli_query($conn, "DELETE FROM keranjang WHERE session_id='$session_id' AND id_menu=$id_menu");
        } else {
            $_SESSION['keranjang'][$id_menu]['qty'] = $jumlah;
            $subtotal = $jumlah * $_SESSION['keranjang'][$id_menu]['harga'];
            // update DB
            mysqli_query($conn, "UPDATE keranjang SET qty=$jumlah, subtotal=$subtotal WHERE session_id='$session_id' AND id_menu=$id_menu");
        }
    }
    header("Location: keranjang.php");
    exit;
}

// Tambah item ke keranjang jika ada id_menu di URL
if (isset($_GET['id_menu'])) {
    $id_menu = intval($_GET['id_menu']);
    $q = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu = $id_menu AND status = 'tersedia'");
    $menu_item = mysqli_fetch_assoc($q);

    if ($menu_item) {
        if (!isset($_SESSION['keranjang'])) $_SESSION['keranjang'] = [];

        if (isset($_SESSION['keranjang'][$id_menu])) {
            $_SESSION['keranjang'][$id_menu]['qty']++;
            $qty = $_SESSION['keranjang'][$id_menu]['qty'];
            $subtotal = $qty * $menu_item['harga'];
            mysqli_query($conn, "UPDATE keranjang SET qty=$qty, subtotal=$subtotal WHERE session_id='$session_id' AND id_menu=$id_menu");
        } else {
            $_SESSION['keranjang'][$id_menu] = [
                'nama_menu' => $menu_item['nama_menu'],
                'harga' => $menu_item['harga'],
                'gambar' => $menu_item['foto'],
                'qty' => 1
            ];
            $subtotal = $menu_item['harga'];
            mysqli_query($conn, "INSERT INTO keranjang (session_id, id_menu, nama_menu, harga, qty, subtotal)
                                 VALUES ('$session_id', $id_menu, '".mysqli_real_escape_string($conn,$menu_item['nama_menu'])."', {$menu_item['harga']}, 1, $subtotal)");
        }
        header("Location: keranjang.php");
        exit;
    }
}

// Hitung total
$total = 0;
if (isset($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $item) {
        $total += $item['harga'] * $item['qty'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang – Katering Kita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Katering Kita</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div style="margin-top:80px"></div>

<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Keranjang Anda</h2>

        <?php if (!isset($_SESSION['keranjang']) || count($_SESSION['keranjang']) == 0): ?>
            <p class="text-center text-muted">Keranjang kosong.</p>
            <div class="text-center">
                <a href="index.php" class="btn btn-primary">Kembali ke Menu</a>
            </div>
        <?php else: ?>
            <form method="POST">
            <table class="table table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Menu</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['keranjang'] as $id => $item): ?>
                        <tr class="text-center">
                            <td><img src="<?= htmlspecialchars($item['gambar']); ?>" alt="" style="height:60px; object-fit:cover;"></td>
                            <td><?= htmlspecialchars($item['nama_menu']); ?></td>
                            <td>Rp <?= number_format($item['harga'],0,',','.'); ?></td>
                            <td>
                                <input type="number" name="qty[<?= $id ?>]" value="<?= $item['qty'] ?>" min="1" class="form-control" style="width:70px; margin:auto;">
                            </td>
                            <td>Rp <?= number_format($item['harga'] * $item['qty'],0,',','.'); ?></td>
                            <td>
                                <a href="hapus_keranjang.php?id_menu=<?= $id; ?>" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-between mb-3">
                <button type="submit" name="update_qty"
    class="btn btn-primary fw-semibold"
    style="
        height: 44px;
        padding: 0 24px;
        border-radius: 14px;
        font-size: 17px;
    ">
    Update Keranjang
</button>

                <div class="text-end">
                    <h5>Total: Rp <?= number_format($total,0,',','.'); ?></h5>
                    <a href="checkout.php" class="btn btn-warning mt-2">Checkout</a>
                </div>
            </div>
            </form>
        <?php endif; ?>
    </div>
</section>

<footer class="bg-dark text-white text-center py-3">
    &copy; <?= date('Y'); ?> Katering Kita
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
