<?php
session_start();

// Pastikan user sudah login
if (empty($_SESSION['username'])) {
    header("location:user_login.php?pesan=belum_login");
    exit();
}

// Ambil ID buku dari URL
if (isset($_GET['id'])) {
    $id_buku = $_GET['id'];

    // Periksa apakah keranjang sudah ada di sesi
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    // Tambahkan buku ke keranjang
    if (isset($_SESSION['keranjang'][$id_buku])) {
        $_SESSION['keranjang'][$id_buku]++;
    } else {
        $_SESSION['keranjang'][$id_buku] = 1;
    }

    // Redirect kembali ke halaman utama dengan pesan sukses
    header("location:main_user.php?pesan=berhasil_tambah");
    exit();
} else {
    header("location:main_user.php?pesan=id_tidak_ditemukan");
    exit();
}
?>
