<?php
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_transaksi = $_POST['id_transaksi'];
    $status = $_POST['status'];

    $query = "UPDATE transaksi SET status = '$status' WHERE id_transaksi = '$id_transaksi'";
    if ($connect->query($query)) {
        header("location:main_admin.php");
    } else {
        echo "Gagal update status";
    }
}
