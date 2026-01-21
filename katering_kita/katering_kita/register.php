<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User – Katering Kita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #FFC107, #FF9800);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .card-register {
            width: 100%;
            max-width: 450px;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .btn-warning {
            color: #fff;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="card-register">
    <h3 class="text-center mb-4 text-warning fw-bold">Daftar Akun</h3>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-info text-center">
            <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
        </div>
    <?php endif; ?>

    <form action="proses_register.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required placeholder="Contoh: Budi Santoso">
        </div>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required placeholder="Username unik">
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
        </div>

        <button type="submit" class="btn btn-warning w-100 py-2">Daftar Sekarang</button>
    </form>

    <div class="text-center mt-3">
        <small>Sudah punya akun? <a href="login.php" class="text-decoration-none fw-bold text-warning">Login disini</a></small>
    </div>
</div>

</body>
</html>
