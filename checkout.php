<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:user_login.php?pesan=belum_login");
    exit();
}

include('koneksi.php');

// Pastikan keranjang tidak kosong
if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    header("location:keranjang.php?pesan=keranjang_kosong");
    exit();
}

// Ambil ID user dari sesi
$username = $_SESSION['username'];
$query_user = "SELECT id_user FROM user WHERE username = '$username'";
$result_user = $connect->query($query_user);
if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
    $id_user = $user['id_user'];
} else {
    header("location:keranjang.php?pesan=user_tidak_ditemukan");
    exit();
}

// Ambil data keranjang
$keranjang = $_SESSION['keranjang'];
$total_harga = 0;
$judul_buku_list = [];

foreach ($keranjang as $id_buku => $jumlah) {
    // Ambil detail buku dari database
    $query_buku = "SELECT judul, harga FROM buku WHERE id_buku = $id_buku";
    $result_buku = $connect->query($query_buku);
    if ($result_buku->num_rows > 0) {
        $buku = $result_buku->fetch_assoc();
        $judul_buku_list[] = $buku['judul'] . " (x$jumlah)";
        $total_harga += $buku['harga'] * $jumlah;
    }
}

// Gabungkan judul buku dalam satu string
$judul_buku = implode(", ", $judul_buku_list);

// Simpan transaksi ke database
$query_transaksi = "INSERT INTO transaksi (id_user, judul_buku, total_harga) VALUES ('$id_user', '$judul_buku', '$total_harga')";
if ($connect->query($query_transaksi)) {
    // Hapus keranjang dari sesi
    unset($_SESSION['keranjang']);
    header("location:keranjang.php?pesan=checkout_sukses");
    exit();
} else {
    header("location:keranjang.php?pesan=checkout_gagal");
    exit();
}
?>
