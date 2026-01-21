<?php
include "../../config.php";
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: /login.php");
    exit;
}

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM pesanan WHERE id_pesanan = '$id'");

header("Location: index.php");
exit;