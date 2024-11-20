<?php
include('koneksi.php');

// Cek apakah ID buku diterima melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_buku'])) {
    $id_buku = $_POST['id_buku'];

    // Query untuk menghapus buku berdasarkan ID
    $query = "DELETE FROM buku WHERE id_buku = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('i', $id_buku);

    if ($stmt->execute()) {
        // Jika berhasil dihapus, kembali ke halaman sebelumnya atau tampilkan pesan sukses
        header('Location: main_admin.php?status=deleted');
        exit();
    } else {
        echo "Gagal menghapus buku: " . $connect->error;
    }
}
?>
