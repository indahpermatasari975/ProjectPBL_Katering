<?php
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] == 'customer') {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User – Katering Kita</title>
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
        .card-login {
            width: 100%;
            max-width: 400px;
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

<div class="card-login">
    <h3 class="text-center mb-4 text-warning fw-bold">Login User</h3>
    <p class="text-center text-muted">Selamat datang kembali!</p>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-info text-center">
            <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center">
            <?= $_GET['error']; ?>
        </div>
    <?php endif; ?>

    <form action="proses_login_user.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required placeholder="Masukkan username">
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
        </div>

        <button type="submit" class="btn btn-warning w-100 py-2">Masuk</button>
    </form>

    <div class="text-center mt-3">
        <small>Belum punya akun? <a href="register_user.php" class="text-decoration-none fw-bold text-warning">Daftar disini</a></small>
        <div class="mt-2">
            <small>Login sebagai Admin? <a href="login.php" class="text-decoration-none text-muted">Klik disini</a></small>
        </div>
    </div>
</div>

</body>
</html>
