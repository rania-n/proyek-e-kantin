<?php
include '../../../Config/koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu='$id' AND deleted=0");

$baris = mysqli_fetch_assoc($data);

if(!$baris){
    echo "Data tidak ditemukan.";
    exit;
}

$error = '';
if(isset($_POST['simpan'])){
    $nama = $_POST['nama_menu'];
    $deskripsi = $_POST['deskripsi'];
    $harga = (int) $_POST['harga'];
    $stok = (int) $_POST['stok'];
    $kategori = $_POST['kategori'];

    $error = '';

    if($nama == ''){
        $error = "Nama menu harus diisi!";
    }
    elseif($harga < 0 || $stok < 0){
        $error = "Harga dan stok tidak boleh minus!";
    } else {
        $foto = $baris['foto'];
        if($_FILES['foto']['name'] != ''){
            $foto = $_FILES['foto']['name'];
            $tmp = $_FILES['foto']['tmp_name'];
            move_uploaded_file($tmp, "../Image/".$foto);
        }
    
        mysqli_query($conn, "UPDATE menu SET nama_menu='$nama', deskripsi='$deskripsi', harga='$harga', stok='$stok', kategori='$kategori', foto='$foto' WHERE id_menu='$id'");
    
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
    <title>Edit Menu</title>
</head>
<body>

    <?php if($error != ''){ ?><p style="color:red;"><?= $error ?></p><?php } ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="nama_menu" value="<?= $baris['nama_menu'] ?>"><br>
        <textarea name="deskripsi"><?= $baris['deskripsi'] ?></textarea><br>
        <input type="number" name="harga" min="0" required value="<?= $baris['harga'] ?>"><br>
        <input type="number" name="stok" min="0" required value="<?= $baris['stok'] ?>"><br>
        <select name="kategori">
            <option value="Makanan Berat" <?= $baris['kategori']=='Makanan Berat'?'selected':''?>>Makanan Berat</option>
            <option value="Makanan Ringan" <?= $baris['kategori']=='Makanan Ringan'?'selected':''?>>Makanan Ringan</option>
            <option value="Makanan Sehat" <?= $baris['kategori']=='Makanan Sehat'?'selected':''?>>Makanan Sehat</option>
            <option value="Minuman" <?= $baris['kategori']=='Minuman'?'selected':''?>>Minuman</option>
        </select><br>
        Opsional <input type="file" name="foto"><br>
        <button type="submit" name="simpan">Simpan</button>
    </form>

</body>
</html>