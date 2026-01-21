<?php
session_start();
include "config.php";

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$menu = mysqli_query($conn, "
    SELECT m.*, k.nama_kategori 
    FROM menu m
    LEFT JOIN kategori_menu k ON m.id_kategori = k.id_kategori
    WHERE m.status = 1
");

$kontak = mysqli_query($conn, "
    SELECT * FROM kontak
    WHERE status_aktif = 1
    ORDER BY id_kontak ASC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katering Kita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        html { scroll-behavior: smooth; scroll-padding-top: 80px; }
        body { font-family: 'Montserrat', sans-serif; background-color: #f8f9fa; }
        .masthead {
            height: 100vh;
            min-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
            color: #fff;
            text-align: center;
            position: relative;
        }
        .masthead-heading { font-size: 2.5rem; font-weight: 700; }
        .portfolio-item {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .portfolio-item:hover { transform: translateY(-5px); }
        .portfolio-item p {
            flex-grow: 1;
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .img-destinasi {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .icon-service {
            transition: transform 0.3s;
        }
        .icon-service:hover {
            transform: scale(1.2) rotate(10deg);
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
            <span class="me-2" style="font-size:1.5rem;">🍱</span> Katering Kita
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="#menu">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="keranjang.php">
                        <i class="fas fa-shopping-cart"></i> Keranjang
                    </a>
                </li>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <li class="nav-item">
                    <a class="btn btn-warning ms-2" href="dashboard/index.php">Dashboard</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="btn btn-danger ms-2" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero -->
<header class="masthead" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://img.freepik.com/foto-gratis/tampak-atas-meja-penuh-makanan_23-2149209231.jpg?semt=ais_hybrid&w=740&q=80'); background-size: cover; background-position: center; margin-top: 0;">
    <div class="container">
        <div class="masthead-heading">Katering Kita</div>
        <p class="lead mb-4">Nikmati Makanan Enak & Higienis</p>
        <a class="btn btn-primary btn-lg rounded-pill shadow px-5 py-3" href="#menu" style="font-weight:600; letter-spacing:1px;">Lihat Menu</a>
    </div>
</header>

<!-- Layanan -->
<section id="layanan" class="py-5">
    <div class="container text-center">
        <h2>Layanan Kami</h2>
        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <i class="fa fa-utensils fa-2x text-success mb-3 icon-service"></i>
                <h5 class="fw-bold">Katering Harian</h5>
                <p class="text-muted small">Menu bervariasi setiap hari dengan gizi seimbang.</p>
            </div>
            <div class="col-md-4 mb-3">
                <i class="fa fa-calendar fa-2x text-primary mb-3 icon-service"></i>
                <h5 class="fw-bold">Event & Acara</h5>
                <p class="text-muted small">Layanan prasmanan untuk pernikahan, seminar, dan acara lainnya.</p>
            </div>
            <div class="col-md-4 mb-3">
                <i class="fa fa-truck fa-2x text-warning mb-3 icon-service"></i>
                <h5 class="fw-bold">Delivery</h5>
                <p class="text-muted small">Pengiriman cepat dan aman sampai ke lokasi Anda.</p>
            </div>
        </div>
    </div>
</section>

<!-- Menu -->
<section id="menu" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Daftar Menu</h2>
        <div class="row">

            <?php while($m = mysqli_fetch_assoc($menu)): ?>
            <div class="col-md-4 mb-4 d-flex align-items-stretch">
                <div class="portfolio-item w-100">
                    <img src="<?= htmlspecialchars($m['foto']) ?>" class="img-destinasi">
                    <h5 class="mt-2"><?= htmlspecialchars($m['nama_menu']) ?></h5>
                    <p><?= htmlspecialchars($m['deskripsi']) ?></p>
                    <div class="mt-auto">
                        <h6 class="text-success">
                            Rp <?= number_format($m['harga'],0,',','.') ?>
                        </h6>
                        <button class="btn btn-success btn-add-cart w-100" data-id="<?= $m['id_menu'] ?>">
                            Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>

        </div>
    </div>
</section>

<!-- Kontak dari Database -->
<section id="kontak" class="py-5">
    <div class="container text-center">
        <h2 class="mb-2 fw-bold">KONTAK KAMI</h2>
        <p class="text-muted mb-4">Hubungi kami melalui salah satu akun berikut.</p>

        <div class="mx-auto" style="max-width:500px;">
            <?php while($k = mysqli_fetch_assoc($kontak)): ?>

                <?php
                // Link otomatis sesuai jenis kontak
                switch ($k['jenis_kontak']) {
                    case 'instagram':
                        $link = "https://instagram.com/" . ltrim($k['nilai'], '@');
                        break;

                    case 'whatsapp':
                        $link = "https://wa.me/" . preg_replace('/[^0-9]/', '', $k['nilai']);
                        break;

                    case 'email':
                        $link = "mailto:" . $k['nilai'];
                        break;
                    case 'lokasi':
                        $link = $k['nilai']; 
                        break;

                    default:
                        $link = "#";
                }
                ?>

                <div class="d-flex align-items-center justify-content-center py-2 border-bottom">
                    <i class="<?= $k['icon'] ?> me-3 fs-5"></i>

                    <a href="<?= $link ?>"
                       target="_blank"
                       class="text-decoration-none fw-semibold text-dark">
                        <?= ucfirst($k['jenis_kontak']) ?>:
                        <span class="text-warning">
                            <?= htmlspecialchars($k['nilai']) ?>
                        </span>
                    </a>
                </div>

            <?php endwhile; ?>
        </div>
    </div>
</section>

<footer class="bg-dark text-white text-center py-3">
    &copy; <?= date('Y') ?> Katering Kita
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.btn-add-cart').forEach(btn => {
    btn.addEventListener('click', function () {
        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: 'id_menu=' + this.dataset.id
        }).then(() => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Menu berhasil ditambahkan ke keranjang',
                icon: 'success',
                confirmButtonColor: '#ffc107',
                confirmButtonText: 'Oke'
            });
        });
    });
});
</script>

</body>
</html>
