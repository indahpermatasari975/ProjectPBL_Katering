<?php
session_start();
include "../../config.php";

if (!isset($_SESSION['role'])) {
    header("Location: /login.php");
    exit;
}

/* ===============================
   AMBIL DATA PESANAN
================================ */
$id = $_GET['id_pesanan'] ?? null;
if (!$id) { header("Location: index.php"); exit; }

$q = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_pesanan='$id'");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    echo "
    <!DOCTYPE html>
    <html>
    <head><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head>
    <body>
    <script>
    Swal.fire({
        title: 'Error!',
        text: 'Data pesanan tidak ditemukan',
        icon: 'error'
    }).then(() => { window.location='index.php'; });
    </script>
    </body>
    </html>";
    exit;
}

/* ===============================
   PROSES UPDATE
================================ */
if (isset($_POST['submit'])) {

    $nama    = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $email   = $_POST['email'];
    $alamat  = $_POST['alamat']; 
    $tanggal = $_POST['tanggal_acara'];
    $total   = $_POST['total_harga'];
    $status  = $_POST['status_pesanan'];

    mysqli_query($conn, "UPDATE pesanan SET
        nama='$nama',
        telepon='$telepon',
        email='$email',
        alamat='$alamat',                     
        tanggal_acara='$tanggal',
        total_harga='$total',
        status_pesanan='$status'
        WHERE id_pesanan='$id'
    ");

    header("Location: index.php");
    exit;
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Pesanan — Dashboard Catering</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/style.css">

    <style>
        .form-label {
            display: block;
            font-weight: 600;
            margin-top: 12px;
            margin-bottom: 5px;
            color: var(--text-color);
        }

        .form-input,
        .form-textarea,
        select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--sidebar-border);
            background: var(--card-bg);
            color: var(--text-color);
            border-radius: 8px;
            margin-bottom: 12px;
            outline: none;
        }

        .form-textarea { height: 120px; }

        .btn-warning {
            padding: 12px 18px;
            background: #f59e0b;
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <a href="../index.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="../menu/index.php"><i class="bi bi-list-ul"></i> Kelola Menu</a>
    <a href="index.php" class="active"><i class="bi bi-cart-check"></i> Kelola Pesanan</a>
    <a href="../pembayaran/index.php"><i class="bi bi-credit-card"></i> Kelola Pembayaran</a>
    <a href="../kontak/index.php"><i class="bi bi-envelope-fill"></i> Kelola Kontak</a>
</div>

<div class="main">

<header>
    <div class="logo">Dashboard Catering</div>
    <div class="right">
        <button id="toggleMode">Dark Mode</button>
        <a href="../../logout.php" style="margin-left:15px;color:#dc2626;font-weight:600;text-decoration:none;">Logout</a>
    </div>
</header>

<div class="content">
<div class="card">

<h2>Edit Pesanan</h2>

<form method="POST">

    <label class="form-label">Nama Pemesan</label>
    <input type="text" name="nama" class="form-input" value="<?= htmlspecialchars($data['nama']) ?>" required>

    <label class="form-label">Telepon</label>
    <input type="text" name="telepon" class="form-input" value="<?= htmlspecialchars($data['telepon']) ?>" required>

    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-input" value="<?= htmlspecialchars($data['email']) ?>" required>

    <label class="form-label">Alamat</label>
    <textarea name="alamat" class="form-textarea"><?= htmlspecialchars($data['alamat']) ?></textarea>

    <label class="form-label">Tanggal Acara</label>
    <input type="date" name="tanggal_acara" class="form-input" value="<?= $data['tanggal_acara'] ?>" required>

    </select>

    <label class="form-label">Total Harga</label>
    <input type="number" name="total_harga" class="form-input" value="<?= $data['total_harga'] ?>" required>

    <label class="form-label">Status Pesanan</label>
    <select name="status_pesanan" class="form-input">
        <option value="menunggu_pembayaran" <?= $data['status_pesanan']=='menunggu_pembayaran'?'selected':'' ?>>Menunggu Pembayaran</option>
        <option value="sudah_bayar" <?= $data['status_pesanan']=='sudah_bayar'?'selected':'' ?>>Sudah Bayar</option>
        <option value="cancel" <?= $data['status_pesanan']=='cancel'?'selected':'' ?>>Cancel</option>
    </select>

    <button type="submit" name="submit" class="btn-warning" style="margin-top:20px;">Update Pesanan</button>

</form>

</div>
</div>

<footer>© <?= date("Y") ?> Dashboard Catering</footer>

</div>
</body>
</html>


<script>
const body = document.body;
const btn = document.getElementById("toggleMode");
if (localStorage.getItem("theme")==="dark") { body.classList.add("dark"); btn.textContent="Light Mode"; }
btn.addEventListener("click",()=>{ 
    body.classList.toggle("dark"); 
    localStorage.setItem("theme",body.classList.contains("dark")?"dark":"light");
    btn.textContent = body.classList.contains("dark") ? "Light Mode" : "Dark Mode";
});
</script>

</body>
</html>
