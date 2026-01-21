<?php
session_start();
include "../../config.php";

/* ===============================
   AMBIL DATA KONTAK
================================ */
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM kontak WHERE id_kontak='$id'");
$k = mysqli_fetch_assoc($data);

if (!$k) {
    echo "
    <!DOCTYPE html>
    <html>
    <head><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head>
    <body>
    <script>
    Swal.fire({
        title: 'Error!',
        text: 'Data kontak tidak ditemukan',
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

    $jenis   = $_POST['jenis_kontak'];
    $nilai   = $_POST['nilai'];
    $icon    = $_POST['icon'];
    $status  = $_POST['status_aktif'];

    mysqli_query($conn, "UPDATE kontak SET
        jenis_kontak='$jenis',
        nilai='$nilai',
        icon='$icon',
        status_aktif='$status'
        WHERE id_kontak='$id'
    ");

    header("Location: index.php");
    exit;
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Kontak — Dashboard Catering</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/style.css">

    <style>
        .form-label {
            display: block;
            font-weight: 600;
            margin-top: 14px;
            margin-bottom: 6px;
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
            outline: none;
        }

        .form-input:focus,
        select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 4px var(--primary);
        }

        .btn-warning {
            margin-top: 20px;
            padding: 12px 18px;
            background: #f59e0b;
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-warning:hover {
            background: #d97706;
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
    <div class="logo">Dashboard Catering</div>
    <div class="right">
        <button id="toggleMode">Dark Mode</button>
        <a href="../../logout.php" style="margin-left:15px;color:#dc2626;font-weight:600;text-decoration:none;">Logout</a>
    </div>
</header>

<!-- ================= CONTENT ================= -->
<div class="content">
    <div class="card">

        <h2>Edit Kontak</h2>

        <form method="POST">

            <label class="form-label">Jenis Kontak</label>
            <select name="jenis_kontak" required>
                <option value="instagram" <?= $k['jenis_kontak']=='instagram'?'selected':'' ?>>Instagram</option>
                <option value="email" <?= $k['jenis_kontak']=='email'?'selected':'' ?>>Email</option>
                <option value="whatsapp" <?= $k['jenis_kontak']=='whatsapp'?'selected':'' ?>>WhatsApp</option>
                <option value="lokasi" <?= $k['jenis_kontak']=='lokasi'?'selected':'' ?>>Lokasi</option>
            </select>

            <label class="form-label">Nilai</label>
            <input type="text" name="nilai" value="<?= htmlspecialchars($k['nilai']) ?>" class="form-input" required>

            <label class="form-label">Icon</label>
            <input type="text" name="icon" value="<?= htmlspecialchars($k['icon']) ?>" class="form-input" placeholder="bi bi-instagram">

            <label class="form-label">Status</label>
            <select name="status_aktif">
                <option value="1" <?= $k['status_aktif']==1?'selected':'' ?>>Aktif</option>
                <option value="0" <?= $k['status_aktif']==0?'selected':'' ?>>Nonaktif</option>
            </select>

            <button type="submit" name="submit" class="btn-warning">
                Update Kontak
            </button>

        </form>

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

</body>
</html>
