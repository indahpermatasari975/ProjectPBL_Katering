<?php
session_start();
include "../../config.php";

/* ===========================
   SIMPAN DATA METODE PEMBAYARAN
=========================== */
if (isset($_POST['submit'])) {

    $nama_metode = $_POST['nama_metode'];
    $status      = $_POST['status'];

    mysqli_query($conn, "INSERT INTO metode_pembayaran SET
        nama_metode = '$nama_metode',
        status      = '$status'
    ");

    header("Location: index.php");
    exit;
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Metode Pembayaran — Catering Dashboard</title>

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
select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 4px var(--primary);
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

    <a href="../menu/index.php">
        <i class="bi bi-card-list"></i> Kelola Menu
    </a>

    <a href="../pesanan/index.php">
        <i class="bi bi-cart-check"></i> Kelola Pesanan
    </a>

    <a href="index.php" class="active">
        <i class="bi bi-credit-card"></i> Kelola Pembayaran
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
        <a href="../../logout.php"
           style="margin-left:15px;color:#dc2626;font-weight:600;text-decoration:none;">
           Logout
        </a>
    </div>
</header>

<!-- =======================================================
     📌 CONTENT TAMBAH PEMBAYARAN
======================================================= -->
<div class="content">
    <div class="card">
        <h2 style="margin-bottom: 20px;">Tambah Metode Pembayaran</h2>

        <form method="POST">

            <label class="form-label">Nama Metode Pembayaran</label>
            <input type="text"
                   name="nama_metode"
                   class="form-input"
                   placeholder="Contoh: Transfer Bank, OVO, DANA"
                   required>

            <label class="form-label">Status</label>
            <select name="status">
                <option value="1">Aktif</option>
                <option value="0">Non Aktif</option>
            </select>

            <button type="submit"
                    name="submit"
                    class="btn-success"
                    style="margin-top:20px;">
                Simpan Metode Pembayaran
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
