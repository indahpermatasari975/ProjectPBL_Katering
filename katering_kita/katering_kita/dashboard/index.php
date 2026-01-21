<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role'] == 'pelanggan') {
    header("Location: ../index.php");
    exit;
}

include "../config.php";

/* ===============================
   DATA STATISTIK
   =============================== */

// jumlah menu
$j_menu = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS jml FROM menu")
)['jml'];

// jumlah pesanan
$j_pesanan = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS jml FROM pesanan")
)['jml'];


//jumlah pembayaran
$j_pembayaran = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS jml FROM metode_pembayaran")
)['jml'];

// jumlah kontak
$j_kontak = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS jml FROM kontak")
)['jml'];
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Catering</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/style.css">

    <style>
        .stat-box {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            margin-top: 25px;
        }
        .stat-card {
            padding: 20px;
            border-radius: 12px;
            background: #ffffff15;
            backdrop-filter: blur(6px);
            border: 2px solid #ffffff20;
            text-align: center;
            transition: 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            background: #ffffff25;
        }
        .stat-card i {
            font-size: 40px;
            margin-bottom: 10px;
            color: #ffd54f;
        }
        .stat-card h3 {
            font-size: 26px;
            margin: 0;
            font-weight: bold;
        }
        .stat-card p {
            margin: 0;
            margin-top: 4px;
            font-size: 14px;
            opacity: 0.8;
        }
        .card {
            border-left: 6px solid #facc15;
        }
        body.dark .stat-card {
            background: #222;
            border-color: #333;
        }
        body.dark .stat-card:hover {
            background: #333;
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <a href="index.php" class="active">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="menu/index.php">
        <i class="bi bi-card-list"></i> Kelola Menu
    </a>
    <a href="pesanan/index.php">
        <i class="bi bi-cart-check"></i> Kelola Pesanan
    </a>
    
    <a href="pembayaran/index.php">
        <i class="bi bi-credit-card"></i> Kelola Pembayaran
    </a>
    <a href="kontak/index.php">
        <i class="bi bi-envelope-fill"></i> Kelola Kontak
    </a>
</div>

<!-- MAIN -->
<div class="main">

<header>
    <a href="../index.php" style="text-decoration: none; color: inherit;">
        <div class="logo">Dashboard admin</div>
    </a>
    <div class="right">
        <button id="toggleMode">Dark Mode</button>
        <a href="../logout.php"
           style="margin-left:15px;color:#dc2626;font-weight:600;text-decoration:none;">
            Logout
        </a>
    </div>
</header>

<div class="content">

    <div class="card">
        <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['nama']) ?></h2>
        <p>Dashboard pengelolaan Menu Catering</p>
    </div>

    <div class="stat-box">

        <div class="stat-card">
            <i class="bi bi-card-list"></i>
            <h3><?= $j_menu ?></h3>
            <p>Total Menu</p>
        </div>

        <div class="stat-card">
            <i class="bi bi-cart-check"></i>
            <h3><?= $j_pesanan ?></h3>
            <p>Total Pesanan</p>
        </div>

    

        <div class="stat-card">
            <i class="bi bi-credit-card"></i>
            <h3><?= $j_pembayaran ?></h3>
            <p>Pembayaran</p>
        </div>

        <div class="stat-card">
            <i class="bi bi-envelope-fill"></i>
            <h3><?= $j_kontak ?></h3>
            <p>Pesan Kontak</p>
        </div>

    </div>

</div>

<footer>
    © <?= date("Y") ?> Catering
</footer>

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

</div>
</body>
</html>
