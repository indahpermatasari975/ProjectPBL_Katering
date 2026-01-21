<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role'])) {
    header("Location: /login.php");
    exit;
}

include "../../config.php";

/* ===============================
   AMBIL DATA KONTAK
================================ */
$q = mysqli_query($conn, "SELECT * FROM kontak ORDER BY id_kontak DESC");
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Kontak — Dashboard Catering</title>

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
            padding: 14px 16px;
            border-bottom: 1px solid #e5f0ff;
            color: var(--text-color);
        }

        .table th {
            font-weight: 700;
        }

        .badge {
            padding: 6px 14px;
            border-radius: 999px;
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
            padding: 6px 12px;
            font-size: 13px;
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
    </style>
</head>

<body>

<!-- ================= SIDEBAR ================= -->
<div class="sidebar">
    <a href="../index.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="../menu/index.php"><i class="bi bi-card-list"></i> Kelola Menu</a>
    <a href="../pesanan/index.php"><i class="bi bi-cart-check"></i> Kelola Pesanan</a>
    <a href="../pembayaran/index.php"><i class="bi bi-credit-card"></i> Kelola Pembayaran</a>
    <a href="index.php" class="active"><i class="bi bi-envelope-fill"></i> Kelola Kontak</a>
</div>

<!-- ================= MAIN ================= -->
<div class="main">

<header>
    <a href="../../index.php" style="text-decoration: none; color: inherit;">
        <div class="logo">Dashboard admin</div>
    </a>
    <div class="right">
        <button id="toggleMode">Dark Mode</button>
        <a href="../../logout.php" style="margin-left:15px;color:#dc2626;font-weight:600;text-decoration:none;">Logout</a>
    </div>
</header>

<!-- ================= CONTENT ================= -->
<div class="content">
    <div class="card">

        <h2>Kelola Kontak</h2>
        <p>Daftar informasi kontak yang ditampilkan di website.</p>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis</th>
                    <th>Nilai</th>
                    <th>Icon</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while ($row = mysqli_fetch_assoc($q)) :
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= ucfirst($row['jenis_kontak']) ?></td>
                    <td><?= $row['nilai'] ?></td>
                    <td><?= $row['icon'] ? '<i class="'.$row['icon'].'"></i>' : '-' ?></td>
                    <td>
                        <?= $row['status_aktif'] == 1
                            ? '<span class="badge badge-success">Aktif</span>'
                            : '<span class="badge badge-danger">Nonaktif</span>' ?>
                    </td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id_kontak'] ?>" class="btn-warning small">Edit</a>
                        <a href="javascript:void(0)" 
                           class="btn-danger small"
                           onclick="confirmDelete('hapus.php?id=<?= $row['id_kontak'] ?>')">
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

<script>
    const body = document.body;
    const btn = document.getElementById("toggleMode");

    if (localStorage.getItem("theme") === "dark") {
        body.classList.add("dark");
        btn.textContent = "Light Mode";
    }

    btn.addEventListener("click", () => {
        body.classList.toggle("dark");
        btn.textContent = body.classList.contains("dark") ? "Light Mode" : "Dark Mode";
        localStorage.setItem("theme", body.classList.contains("dark") ? "dark" : "light");
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
