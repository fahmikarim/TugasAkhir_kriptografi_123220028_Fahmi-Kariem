<?php
include('koneksi.php');
include('steganography_functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_transaksi = $_POST['id_transaksi'];
    $message = $_POST['message'];
    $image = $_FILES['image'];

    if ($image['type'] !== 'image/png') {
        die("Hanya file PNG yang diperbolehkan.");
    }

    $tempImage = $image['tmp_name'];
    $outputPath = 'uploads/stegano_' . uniqid() . '.png';

    // Enkripsi pesan ke dalam gambar
    $result = encryptImage($tempImage, $message, $outputPath);

    if (strpos($result, 'successfully') !== false) {
        // Simpan path gambar ke database
        $stmt = $connect->prepare("UPDATE transaksi SET steganografi_image = ? WHERE id_transaksi = ?");
        $stmt->bind_param('si', $outputPath, $id_transaksi);
        $stmt->execute();
        header("Location: transaksi_user.php?pesan=stegano_success");
    } else {
        die("Gagal mengenkripsi pesan.");
    }
}
?>
