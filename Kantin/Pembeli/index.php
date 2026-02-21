<?php
session_start();
include '../../Config/koneksi.php';

$pesan = '';
if(isset($_SESSION['pesan'])){
    $pesan = $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}

if(isset($_GET['kategori']) && $_GET['kategori'] != ''){
    $kategori = $_GET['kategori'];
    $query = "SELECT * FROM menu WHERE kategori='$kategori' AND deleted=0 AND status='aktif' ORDER by created DESC";
} else {
    $query = "SELECT * FROM menu WHERE deleted=0 AND status='aktif' ORDER BY created DESC";
}
$data = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Kantin</title>
    <style> 
    .kategori a { background-color: yellow; padding: 5px 10px; border-radius: 40%; display: inline-block; text-align: center; }
    img { width: 120px; aspect-ratio: 1 / 1; object-fit: cover; }

    </style>
</head>
<body>
    <?php if($pesan != ''){ ?>
    <div style="background:#ffdddd; padding:10px; margin:10px 0; border-radius:8px;">
        <?= $pesan ?>
    </div>
<?php } ?>
    <?php include 'Layout/1-header.html' ?>

    <input type="text" placeholder="Cari menu . . ." class="search">

    <div class="kategori">
        <a href="index.php">Semua</a>
        <a href="index.php?kategori=Makanan Berat">Makanan Berat</a>
        <a href="index.php?kategori=Makanan Ringan">Makanan Ringan</a>
        <a href="index.php?kategori=Makanan Sehat">Makanan Sehat</a>
        <a href="index.php?kategori=Minuman">Minuman</a>
    </div>

    <div class="menu">
        <?php while($baris = mysqli_fetch_assoc($data)) { ?>
            <img src="../Image/<?php echo $baris['foto'] ?>">
            <h3><?php echo $baris['nama_menu'] ?></h3>
            <p><?php echo $baris['deskripsi'] ?></p>
            <p>Stok: <?php echo $baris['stok'] ?></p>
            <p>Rp <?php echo number_format($baris['harga'],0,',','.') ?></p>
            <a href="proses-keranjang.php?proses=tambah&id=<?= $baris['id_menu'] ?>">+ Keranjang</a>
        </div>
        <?php } ?>
    </div>

    <?php include 'Layout/2-footer.html' ?>
</body>
</html>