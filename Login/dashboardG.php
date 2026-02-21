<?php
session_start();
if($_SESSION['role'] != 'guru'){
    header("Location: loginS.html");
}
?>

<h2>Dashboard Guru</h2>
<p>Selamat datang, <?php echo $_SESSION['nama']; ?></p>
<a href="logout.php">Logout</a>