 <?php
session_start();
include "config.php";

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'pelanggan') {
        header("Location: index.php");
    } else {
        header("Location: dashboard/index.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login – Menu Katering</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #FFC107, #FF9800);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            color: #fff;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            padding: 35px;
            border-radius: 18px;
            color: #333;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            transition: 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-3px);
        }

        .login-card h3 {
            text-align: center;
            margin-bottom: 10px;
            font-weight: 700;
            color: #FFC107;
        }

        .login-card p {
            text-align: center;
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 12px;
        }

        .form-control:focus {
            border-color: #FFC107;
            box-shadow: 0 0 6px rgba(25, 135, 84, 0.4);
        }

        .btn-primary {
            background-color: #FFC107;
            border: none;
            font-weight: 600;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background-color: #FF9800;
        }

        .back-btn {
            display: block;
            margin-top: 18px;
            text-align: center;
            color: #6c757d;
            text-decoration: none;
            font-size: 14px;
        }

        .back-btn:hover {
            color: #FFC107;
            text-decoration: underline;
        }

        .logo {
            font-size: 40px;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<div class="login-card">

    <div class="logo">🍱</div>

    <h3>Menu Katering</h3>
    <p>Silakan login untuk melanjutkan pemesanan</p>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center">
            <?= $_GET['error']; ?>
        </div>
    <?php endif; ?>

    <form action="proses_login.php" method="POST">

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
        </div>

        <button class="btn btn-primary w-100 py-2 mt-2">
            Login
        </button>
    </form>

    <div class="text-center mt-3">
        <small>Belum punya akun? <a href="register.php" class="text-decoration-none fw-bold" style="color:#FFC107;">Daftar disini</a></small>
    </div>

</div>

</body>
</html>
