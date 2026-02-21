<?php
session_start();
if($_SESSION['role'] != 'penjual'){
    header("Location: loginP.html");
}
?>

<h2>Dashboard Penjual</h2>
<p>Selamat datang, <?php echo $_SESSION['nama']; ?></p>
<a href="logout.php">Logout</a>
