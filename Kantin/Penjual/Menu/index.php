<?php
include '../../../Config/koneksi.php';

if(isset($_GET['kategori']) && $_GET['kategori'] != ''){
    $kategori = $_GET['kategori'];
    $query = "SELECT * FROM menu WHERE kategori='$kategori' AND deleted=0 ORDER by created DESC";
} else {
    $query = "SELECT * FROM menu WHERE deleted=0 ORDER BY created DESC";
}
$data = mysqli_query($conn, $query);

$error = '';
if(isset($_POST['simpan'])) {
    $nama = $_POST['nama_menu'];
    $deskripsi = $_POST['deskripsi'];
    $harga = (int) $_POST['harga'];
    $stok = (int) $_POST['stok'];
    $kategori = $_POST['kategori'];

    $id_kantin = $_POST['id_kantin'];

    $error = '';
    if($nama == ''){
        $error = "Nama menu harus diisi!";
    }
    elseif($harga < 0 || $stok < 0){
        $error = "Harga dan stok tidak boleh minus!";
    } else {
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    if($foto != '') move_uploaded_file($tmp, "../Image/".$foto);

    mysqli_query ($conn, "INSERT INTO menu (id_kantin, nama_menu, harga, stok, kategori, deskripsi, foto, status, deleted)
            VALUES ('$id_kantin', '$nama', '$harga', '$stok', '$kategori', '$deskripsi', '$foto', 'aktif', 0)");

    header("Location: index.php");
    exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Kantin</title>
    <style> 
    .tambah-menu { background-color: cyan; padding: 5px 10px; border-radius: 40%; display: inline-block; text-align: center; }
    .kategori { display: flex; gap: 20px; }
    .kategori a { background-color: yellow; padding: 5px 10px; border-radius: 40%; display: inline-block; text-align: center; }
    img { width: 120px; aspect-ratio: 1 / 1; object-fit: cover; }

    .nonaktif { background-color: #ddd; opacity: 0.6; }

    .overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); visibility: hidden; opacity: 0; }
    .overlay:target { visibility: visible; opacity: 1; }
    .popup { background: #fff; width: 400px; margin: 50px auto; padding: 20px; position: relative; }
    .close { position: absolute; right: 10px; top: 5px; text-decoration: none; font-size: 25px; color: #000; }

    </style>
</head>
<body>
    <?php include '../Layout/header.html' ?>

    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
    <div class="tambah-menu"><a href="#tambah-menu">+ Tambah Menu</a></div>

    <div class="kategori">
        <a href="index.php">Semua</a>
        <a href="index.php?kategori=Makanan Berat">Makanan Berat</a>
        <a href="index.php?kategori=Makanan Ringan">Makanan Ringan</a>
        <a href="index.php?kategori=Makanan Sehat">Makanan Sehat</a>
        <a href="index.php?kategori=Minuman">Minuman</a>
    </div>

    <div class="menu-container">
        <?php while($baris = mysqli_fetch_assoc($data)) { ?>
        <div class="menu <?= $baris['status']=='nonaktif'?'nonaktif':'' ?>">
            <img src="../Image/<?php echo $baris['foto'] ?>">
            <h3><?php echo $baris['nama_menu'] ?></h3>
            <p><?php echo $baris['deskripsi'] ?></p>
            <p>Stok: <?php echo $baris['stok'] ?></p>
            <p>Rp <?php echo number_format($baris['harga'],0,',','.') ?></p>

            <a href="edit-menu.php?id=<?php echo $baris['id_menu'] ?>">Edit</a>
            
            <?php if($baris['status']=='aktif') { ?>
            <a href="status-menu.php?id=<?= $baris['id_menu'] ?>&status=nonaktif">Nonaktif</a>
            <?php } else { ?>
            <a href="status-menu.php?id=<?= $baris['id_menu'] ?>&status=aktif">Aktifkan</a>
            <?php } ?>

            <a href="hapus-menu.php?id=<?= $baris['id_menu'] ?>"
               onclick="return confirm('Hapus menu?')">Hapus</a>
        </div>
        <?php } ?>
    </div>

    <?php if($error != ''){ ?><p style="color:red;"><?= $error ?></p><?php } ?>
    <div id="tambah-menu" class="overlay">
        <div class="popup">
            <a href="#" class="close">x</a>
            <form method="POST" enctype="multipart/form-data">
                <input type="number" name="id_kantin" placeholder="ID Kantin (sementara)"><br>
                <input type="text" name="nama_menu" placeholder="Nama Menu"><br>
                <textarea name="deskripsi" placeholder="Deskripsi"></textarea><br>
                <input type="number" name="harga" placeholder="Harga" min="0" required><br>
                <input type="number" name="stok" placeholder="Stok" min="0" required><br>
                <select name="kategori">
                    <option value="Makanan Berat">Makanan Berat</option>
                    <option value="Makanan Ringan">Makanan Ringan</option>
                    <option value="Makanan Sehat">Makanan Sehat</option>
                    <option value="Minuman">Minuman</option>
                </select><br>
                <input type="file" name="foto"><br>
                <button type="submit" name="simpan">Simpan</button>
            </form>
        </div>
    </div>
</body>
</html>