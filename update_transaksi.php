<?php
session_start();
include('koneksi.php');

if (isset($_POST['id_transaksi'])) {
    $id_transaksi = $_POST['id_transaksi'];
    $status = $_POST['status'];
    $bukti_pembayaran = null;

    // Proses upload bukti pembayaran
    if (isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] == 0) {
        $upload_dir = "uploads/";
        $filename = basename($_FILES['bukti_pembayaran']['name']);
        $target_file = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $target_file)) {
            $bukti_pembayaran = $target_file;
        }
    }

    // Update data transaksi
    $query = "UPDATE transaksi SET status = '$status'";
    if ($bukti_pembayaran) {
        $query .= ", bukti_pembayaran = '$bukti_pembayaran'";
    }
    $query .= " WHERE id_transaksi = $id_transaksi";

    if ($connect->query($query)) {
        header("Location: transaksi_admin.php?pesan=update_sukses");
    } else {
        header("Location: transaksi_admin.php?pesan=update_gagal");
    }
} else {
    header("Location: transaksi_admin.php?pesan=invalid_request");
}
?>
