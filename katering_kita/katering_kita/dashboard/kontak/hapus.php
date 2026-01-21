<?php
include "../../config.php";

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM kontak WHERE id_kontak='$id'");

header("Location: index.php");
exit;
?>
