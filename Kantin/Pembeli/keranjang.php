
<?php
session_start();
include '../../Config/koneksi.php';
?>

<?php
$pesan = '';
if(isset($_SESSION['pesan'])){
    $pesan = $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}
?>

<h2>Keranjang</h2>

<?php if($pesan != ''){ ?>
    <div style="background:#ffdddd; padding:10px; margin:10px 0; border-radius:8px;">
        <?= $pesan ?>
    </div>
<?php } ?>

<?php if(!isset($_SESSION['keranjang'])||empty($_SESSION['keranjang'])) { ?>
<p>Keranjang kosong.</p>
<?php } else { ?>
<?php foreach($_SESSION['keranjang'] as $id => $jumlah) {
    $get = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu='$id'");
    $data = mysqli_fetch_assoc($get);
?>

<div class="menu">
    <h3><?= $data['nama_menu']?></h3>
    <a href="proses-keranjang.php?proses=kurang&id=<?= $id ?>">-</a>
    <strong><?= $jumlah ?></strong>
    <a href="proses-keranjang.php?proses=tambah&id=<?= $id ?>">+</a>
    <a href="proses-keranjang.php?proses=hapus&id=<?= $id ?>">Hapus</a>
</div>

<?php } ?>

<?php } ?>

<?php include 'Layout/2-footer.html' ?>

