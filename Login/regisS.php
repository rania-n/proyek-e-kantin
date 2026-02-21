<?php
include "config.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nama     = $_POST['nama_lengkap'];
    $kelas    = $_POST['kelas'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if(strlen($password) < 8){
        echo "<script>
                alert('Password minimal 8 karakter!');
                window.location='regisS.html';
              </script>";
        exit;
    }
    if($password !== $confirm){
        echo "<script>
                alert('Password tidak sama!');
                window.location='regisS.html';
              </script>";
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $role = "siswa";
    $query = "INSERT INTO users (nama_lengkap, kelas, role, email, password)
              VALUES ('$nama','$kelas','$role','$email','$hash')";

    if(mysqli_query($conn,$query)){
        echo "<script>
                alert('Registrasi berhasil!');
                window.location='loginS.html';
              </script>";
    }else{
        echo "<script>
                alert('Email sudah terdaftar!');
                window.location='regisS.html';
              </script>";
    }
}
?>