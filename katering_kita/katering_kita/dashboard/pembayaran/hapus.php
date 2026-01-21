<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role'])) {
    header("Location: /login.php");
    exit;
}

include "../../config.php";

$id = $_GET['id'];

mysqli_query(
    $conn,
    "DELETE FROM metode_pembayaran WHERE id_metode = '$id'"
);

header("Location: index.php");
exit;
