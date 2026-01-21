<?php
session_start();
include "../../config.php";

/* ===============================
   AMBIL DATA MENU
================================ */
$id = $_GET['id_menu'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu='$id'");
$m = mysqli_fetch_assoc($data);

if (!$m) {
    echo "
    <!DOCTYPE html>
    <html>
    <head><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head>
    <body>
    <script>
    Swal.fire({
        title: 'Error!',
        text: 'Data menu tidak ditemukan',
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

    $nama_menu = $_POST['nama_menu'];
    $deskripsi = $_POST['deskripsi'];
    $harga     = $_POST['harga'];
    $status    = $_POST['status'];
    $foto      = $_POST['foto'];

    mysqli_query($conn, "UPDATE menu SET
        nama_menu='$nama_menu',
        deskripsi='$deskripsi',
        harga='$harga',
        status='$status',
        foto='$foto'
        WHERE id_menu='$id'
    ");

    header("Location: index.php");
    exit;
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Menu — Catering Dashboard</title>

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

        .btn-warning {
            padding: 12px 18px;
            background: #f59e0b;
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.25s;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .preview-img {
            margin-top: 12px;
            border-radius: 8px;
            border: 1px solid var(--sidebar-border);
            padding: 4px;
            background: var(--card-bg);
        }
    </style>

</head>

<body>

    <!-- =======================================================
     🧭 SIDEBAR 
======================================================= -->
    <div class="sidebar">
        <a href="../index.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="index.php" class="active"><i class="bi bi-card-list"></i> Kelola Menu</a>
        <a href="../pesanan/index.php"><i class="bi bi-cart-check"></i> Kelola Pesanan</a>
        <a href="index.php" class="active"><i class="bi bi-card-list"></i> Kelola Pembayaran</a>
        <a href="../kontak/index.php"><i class="bi bi-envelope-fill"></i> Kelola Kontak</a>
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
     📌 CONTENT KHUSUS EDIT MENU
======================================================= -->
        <div class="content">
            <div class="card">

                <h2>Edit Menu</h2>

                <form method="POST">

                    <label class="form-label">Nama Menu</label>
                    <input type="text" name="nama_menu" value="<?= htmlspecialchars($m['nama_menu']) ?>" class="form-input" required>

                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-textarea"><?= htmlspecialchars($m['deskripsi']) ?></textarea>

                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" value="<?= $m['harga'] ?>" class="form-input" required>

                    <label class="form-label">Status</label>
                    <select name="status">
                        <option value="tersedia" <?= ($m['status'] == 'tersedia') ? 'selected' : '' ?>>Tersedia</option>
                        <option value="habis" <?= ($m['status'] == 'habis') ? 'selected' : '' ?>>Habis</option>
                    </select>

                    <label class="form-label">URL Foto</label>
                    <input type="text" name="foto" value="<?= $m['foto'] ?>" class="form-input">

                    <?php if (!empty($m['foto'])) : ?>
                        <img src="<?= $m['foto'] ?>" width="120" class="preview-img">
                    <?php endif; ?>

                    <button type="submit" name="submit" class="btn-warning">Update Menu</button>

                </form>

            </div>
        </div>

        <footer>
            © <?= date("Y") ?> Catering Dashboard — All Rights Reserved
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
