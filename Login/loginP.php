<?php
session_start();
include "config.php";

$email = $_POST['email'];
$pass  = $_POST['password'];

$query = mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND role='penjual'");
$data = mysqli_fetch_assoc($query);

if($data && password_verify($pass,$data['password'])){
    $_SESSION['id'] = $data['id'];
    $_SESSION['nama'] = $data['nama_lengkap'];
    $_SESSION['role'] = $data['role'];
    header("Location: dashboardP.php");
}else{
    echo "<script>alert('Login gagal');window.location='loginP.html';</script>";
}
?>