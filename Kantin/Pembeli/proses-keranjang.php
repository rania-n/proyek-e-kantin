<?php
session_start();
include '../../Config/koneksi.php';

$proses = $_GET['proses'];
$id = $_GET['id'];

if(!isset($_SESSION['keranjang'])){
    $_SESSION['keranjang'] = [];
}

$pesan = '';
if($proses=='tambah'){
    $get = mysqli_query($conn, "SELECT stok FROM menu WHERE id_menu='$id'");
    $data = mysqli_fetch_assoc($get);
    $stok = $data['stok'];
    
    $updated_stok = isset($_SESSION['keranjang'][$id]) ? $_SESSION['keranjang'][$id]: 0;
    
    if($updated_stok < $stok){
        $_SESSION['keranjang'][$id] = $updated_stok + 1;
    } else {
        $_SESSION['pesan'] = "Stok tidak mencukupi!";
    }
} elseif($proses=='kurang'){
    if(isset($_SESSION['keranjang'][$id])){
        $_SESSION['keranjang'][$id]--;
        if($_SESSION['keranjang'][$id]<=0){
            unset($_SESSION['keranjang'][$id]);
        }
    }
} elseif($proses=='hapus'){
    unset($_SESSION['keranjang'][$id]);
}

$back = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
header("Location: $back");
exit;
?>