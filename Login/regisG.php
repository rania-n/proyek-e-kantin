<?php
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nama     = $_POST['nama_lengkap'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if($password !== $confirm){
        echo "<script>
                alert('Password tidak sama!');
                window.location='regisG.html';
              </script>";
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $role = "guru";
    $query = "INSERT INTO users (nama_lengkap, kelas, role, email, password)
              VALUES ('$nama','-','$role','$email','$hash')";

    if(mysqli_query($conn,$query)){
        echo "<script>
                alert('Registrasi berhasil!');
                window.location='loginG.html';
              </script>";
    }else{
        echo "<script>
                alert('Email sudah terdaftar!');
                window.location='regisG.html';
              </script>";
    }
}
?>