<?php
session_start();
include "../../config.php";

/* ===========================
   SIMPAN DATA MENU
=========================== */
if (isset($_POST['submit'])) {

    $nama_menu   = $_POST['nama_menu'];
    $deskripsi   = $_POST['deskripsi'];
    $harga       = $_POST['harga'];
    $foto        = $_POST['foto'];
    $status      = $_POST['status'];

    mysqli_query($conn, "INSERT INTO menu SET
        nama_menu   = '$nama_menu',
        deskripsi   = '$deskripsi',
        harga       = '$harga',
        foto        = '$foto',
        status      = '$status'
    ");

    header("Location: index.php");
    exit;
}

/* ===========================
   AMBIL DATA KATEGORI
=========================== */
$kategori = mysqli_query($conn, "SELECT * FROM kategori_menu ORDER BY nama_kategori ASC");
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Menu — Catering Dashboard</title>

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
    transition: 0.25s ease;
}

.form-input:focus,
.form-textarea:focus,
select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 4px var(--primary);
}

.form-textarea {
    height: 130px;
    resize: vertical;
}

.btn-success {
    padding: 12px 18px;
    background: #4caf50;
    border: none;
    color: white;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.25s;
}

.btn-success:hover {
    background: #43a047;
}
</style>
</head>

<body>

<!-- =======================================================
     🧭 SIDEBAR
======================================================= -->
<div class="sidebar">
    <a href="../index.php">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="index.php" class="active">
        <i class="bi bi-card-list"></i> Kelola Menu
    </a>

    <a href="../pesanan/index.php">
        <i class="bi bi-cart-check"></i> Kelola Pesanan
    </a>

     <a href="../pembayaran/index.php">
        <i class="bi bi-cart-check"></i> Kelola Pembayaran
    </a>

    <a href="../kontak/index.php">
        <i class="bi bi-envelope-fill"></i> Kelola Kontak
    </a>
</div>

<!-- =======================================================
     📄 MAIN
======================================================= -->
<div class="main">

<header>
    <div class="logo">Catering Dashboard</div>

    <div class="right">
        <button id="toggleMode">Dark Mode</button>
        <a href="../../logout.php" style="margin-left:15px;color:#dc2626;font-weight:600;text-decoration:none;">Logout</a>
    </div>
</header>

<!-- =======================================================
     📌 CONTENT TAMBAH MENU
======================================================= -->
<div class="content">
    <div class="card">
        <h2 style="margin-bottom: 20px;">Tambah Menu</h2>

        <form method="POST">

            

            <label class="form-label">Nama Menu</label>
            <input type="text" name="nama_menu" class="form-input" required>

            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-textarea"></textarea>

            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-input" required>

            <label class="form-label">URL Foto</label>
            <input type="text" name="foto" class="form-input" placeholder="https://contoh.com/foto.jpg">

            <label class="form-label">Status</label>
            <select name="status">
                <option value="tersedia">Tersedia</option>
                <option value="habis">Habis</option>
            </select>

            <button type="submit" name="submit" class="btn-success" style="margin-top:20px;">
                Simpan Menu
            </button>

        </form>
    </div>
</div>

<footer>
    © <?= date("Y") ?> Catering Dashboard
</footer>

</div>

<!-- =======================================================
     🌙 DARK MODE SCRIPT
======================================================= -->
<script>
    const body = document.body;
    const btn = document.getElementById("toggleMode");

    if (localStorage.getItem("theme") === "dark") {
        body.classList.add("dark");
        btn.textContent = "Light Mode";
    }

    btn.addEventListener("click", () => {
        body.classList.toggle("dark");

        if (body.classList.contains("dark")) {
            localStorage.setItem("theme", "dark");
            btn.textContent = "Light Mode";
        } else {
            localStorage.setItem("theme", "light");
            btn.textContent = "Dark Mode";
        }
    });
</script>

</body>
</html>
