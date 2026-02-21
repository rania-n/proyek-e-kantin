<?php
include '../../../Config/koneksi.php';

$id = $_GET['id'];
$status = $_GET['status'];

mysqli_query($conn, "UPDATE menu SET status='$status' WHERE id_menu='$id'");

header("Location: index.php");
exit;
?>