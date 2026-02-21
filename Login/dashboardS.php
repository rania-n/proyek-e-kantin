<?php
session_start();
if($_SESSION['role'] != 'siswa'){
    header("Location: loginS.html");
}
?>

<h2>Dashboard Siswa</h2>
<p>Selamat datang, <?php echo $_SESSION['nama']; ?></p>
<a href="logout.php">Logout</a>
