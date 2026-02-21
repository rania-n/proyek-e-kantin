<?php 
include '../../../Config/koneksi.php';

$id =$_GET['id'];

mysqli_query($conn, "UPDATE menu SET deleted=1, deleted_at=NOW() WHERE id_menu='$id'");

header("Location: index.php");
exit;
?>