<?php
include "config.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nama     = $_POST['nama_lengkap'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if(strlen($password) < 8){
        echo "<script>
                alert('Password harus minimal 8 karakter!');
                window.location='regisP.html';
              </script>";
        exit;
    }

    if($password !== $confirm){
        echo "<script>
                alert('Konfirmasi password tidak sama!');
                window.location='regisP.html';
              </script>";
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $role = "penjual";
    $query = "INSERT INTO users (nama_lengkap, kelas, role, email, password)
              VALUES ('$nama','-','$role','$email','$hash')";

    if(mysqli_query($conn, $query)){
        echo "<script>
                alert('Registrasi berhasil!');
                window.location='loginP.html';
              </script>";
    } else {
        echo "<script>
                alert('Email sudah terdaftar!');
                window.location='regisP.html';
              </script>";
    }
}
?>