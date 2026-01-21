<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role'])) {
    header("Location: /login.php");
    exit;
}

$admin = "/dashboard";

// ====== KONEKSI DATABASE ======
include "../../config.php";

$query = mysqli_query($conn, "SELECT * FROM menu ORDER BY id_menu DESC");
$menu = [];
while ($row = mysqli_fetch_assoc($query)) {
    $menu[] = $row;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kelola Menu — Dashboard Catering</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/style.css">

    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--sidebar-border);
            text-align: left;
            color: var(--text-color);
        }

        .table th {
            background: var(--card-bg);
            font-weight: 700;
        }

        .badge {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
        }

        .badge-success {
            background: #4caf50;
            color: #fff;
        }

        .badge-danger {
            background: #f44336;
            color: #fff;
        }

        .btn-warning.small,
        .btn-danger.small {
            padding: 6px 10px;
            font-size: 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-warning.small {
            background: #ffa726;
            color: white;
        }

        .btn-danger.small {
            background: #e53935;
            color: white;
        }

        .btn-warning.small:hover {
            background: #fb8c00;
        }

        .btn-danger.small:hover {
            background: #c62828;
        }
    </style>
</head>

<body>

<!-- =======================================================
     🧭 SIDEBAR 
======================================================= -->
<div class="sidebar">
    <a href="../index.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="index.php" class="active"><i class="bi bi-list"></i> Kelola Menu</a>
    <a href="../pesanan/index.php"><i class="bi bi-cart-check"></i> Kelola Pesanan</a>
    <a href="../pembayaran/index.php"><i class="bi bi-wallet2"></i> Kelola Pembayaran</a>
    <a href="../kontak/index.php"><i class="bi bi-envelope-fill"></i> Kelola Kontak</a>
</div>

<!-- =======================================================
     📄 MAIN 
======================================================= -->
<div class="main">

<header>
    <a href="../../index.php" style="text-decoration: none; color: inherit;">
        <div class="logo">Dashboard admin</div>
    </a>

    <div class="right">
        <button id="toggleMode">Dark Mode</button>
        <a href="../../logout.php" style="margin-left: 15px; color:#dc2626; font-weight:600; text-decoration:none;">Logout</a>
    </div>
</header>

<!-- =======================================================
     📌 CONTENT KELOLA MENU
======================================================= -->
<div class="content">
    <div class="card">

        <h2 style="margin-bottom: 10px;">Kelola Menu</h2>
        <p>Daftar menu katering yang tersedia dalam sistem.</p>

        <a href="tambah.php"
           style="
           padding: 8px 15px; 
           background: var(--primary); 
           color:white; 
           border-radius:6px; 
           text-decoration:none;
           font-weight:600;
           display:inline-block;
           margin: 15px 0;">
            + Tambah Menu
        </a>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php if (empty($menu)): ?>
                <tr>
                    <td colspan="5" class="td-center">Belum ada data menu.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($menu as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_menu']) ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td>
                            <span class="badge <?= $row['status'] === 'aktif' ? 'badge-success' : 'badge-danger' ?>">
                                <?= ucfirst($row['status']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit.php?id_menu=<?= $row['id_menu'] ?>" class="btn-warning small">Edit</a>
                            <a href="#" onclick="confirmDelete('hapus.php?id_menu=<?= $row['id_menu'] ?>')" class="btn-danger small">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

<footer>
    © <?= date("Y") ?> Dashboard Catering — All Rights Reserved
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(url) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>

</body>
</html>
