<?php
session_start();
include "../../config.php";

$id = $_GET['id_menu'];

mysqli_query($conn, "DELETE FROM menu WHERE id_menu='$id'");

header("Location: index.php");
exit;
