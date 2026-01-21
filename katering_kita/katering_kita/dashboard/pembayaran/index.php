<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role'])) {
    header("Location: /login.php");
    exit;
}

// ====== KONEKSI DATABASE ======
include "../../config.php";

// QUERY METODE PEMBAYARAN
$q = mysqli_query(
    $conn,
    "SELECT * FROM metode_pembayaran ORDER BY id_metode DESC"
);
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pembayaran — Dashboard Admin</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/style.css">

    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--sidebar-border);
            text-align: left;
        }

        .table th {
            background: var(--card-bg);
            font-weight: 700;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
        }

        .badge-success { background:#4caf50; color:#fff; }
        .badge-danger  { background:#f44336; color:#fff; }

        .btn-warning.small,
        .btn-danger.small {
            padding: 6px 10px;
            font-size: 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            color: white;
        }

        .btn-warning.small { background:#ffa726; }
        .btn-danger.small  { background:#e53935; }
    </style>
</head>

<body>

<!-- ================= SIDEBAR ================= -->
<div class="sidebar">
    <a href="../index.php">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="../menu/index.php">
        <i class="bi bi-list"></i> Kelola Menu
    </a>

    <a href="../pesanan/index.php">
        <i class="bi bi-cart-check"></i> Kelola Pesanan
    </a>

    <a href="../pembayaran/index.php" class="active">
        <i class="bi bi-credit-card"></i> Kelola Pembayaran
    </a>

    <a href="../kontak/index.php">
        <i class="bi bi-envelope"></i> Kelola Kontak
    </a>
</div>

<!-- ================= MAIN ================= -->
<div class="main">

<header>
    <a href="../../index.php" style="text-decoration: none; color: inherit;">
        <div class="logo">Dashboard admin</div>
    </a>
    <div class="right">
        <button id="toggleMode">Dark Mode</button>
        <a href="../../logout.php"
           style="margin-left:15px;color:#dc2626;font-weight:600;text-decoration:none;">
            Logout
        </a>
    </div>
</header>

<!-- ================= CONTENT ================= -->
<div class="content">
<div class="card">

    <h2>Kelola Pembayaran</h2>
    <p>Daftar metode pembayaran yang tersedia.</p>

    <a href="tambah.php"
       style="
        padding:8px 15px;
        background:var(--primary);
        color:white;
        border-radius:6px;
        text-decoration:none;
        font-weight:600;
        display:inline-block;
        margin:15px 0;">
        + Tambah Metode Pembayaran
    </a>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Metode</th>
                <th>Status</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row=mysqli_fetch_assoc($q)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_metode']) ?></td>

                <td>
                    <?php if ($row['status'] == 1): ?>
                        <span class="badge badge-success">Aktif</span>
                    <?php else: ?>
                        <span class="badge badge-danger">Non Aktif</span>
                    <?php endif; ?>
                </td>

                <td><?= date('Y-m-d H:i', strtotime($row['created_at'])) ?></td>

                <td>
                    <a href="edit.php?id=<?= $row['id_metode'] ?>"
                       class="btn-warning small">Edit</a>

                    <a href="#"
                       onclick="confirmDelete('hapus.php?id=<?= $row['id_metode'] ?>')"
                       class="btn-danger small">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</div>
</div>

<footer>
    © <?= date("Y") ?> Dashboard Catering
</footer>

</div>

<!-- ================= DARK MODE ================= -->
<script>
const body = document.body;
const btn = document.getElementById("toggleMode");

if (localStorage.getItem("theme") === "dark") {
    body.classList.add("dark");
    btn.textContent = "Light Mode";
}

btn.addEventListener("click", () => {
    body.classList.toggle("dark");
    localStorage.setItem("theme",
        body.classList.contains("dark") ? "dark" : "light");
    btn.textContent =
        body.classList.contains("dark") ? "Light Mode" : "Dark Mode";
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
