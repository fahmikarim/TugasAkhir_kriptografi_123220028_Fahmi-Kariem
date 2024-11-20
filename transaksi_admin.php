<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:user_login.php?pesan=belum_login");
    exit();
}

include('koneksi.php');

// Ambil semua data transaksi
$query = "SELECT * FROM transaksi ORDER BY created_at DESC";
$result = $connect->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="images/img-logo.png" type="image/png">
</head>

<body style="background: #E2F1E7;">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Data Transaksi</h2>
        <?php if ($result->num_rows > 0) : ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID User</th>
                        <th>Produk</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Bukti Pembayaran</th>
                        <th>Aksi</th>
                        <th>Steganografi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('koneksi.php');
                    include('aes.php');
                    $query = "SELECT * FROM transaksi"; // Query semua transaksi
                    $result = $connect->query($query);
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        $id_transaksi = $row['id_transaksi'];
                        $id_user = $row['id_user'];
                        $produk = $row['judul_buku']; // Sesuaikan nama kolom
                        $total_harga = $row['total_harga'];
                        $status = $row['status'];
                        $bukti_pembayaran = $row['bukti_pembayaran'];
                        $kunci = $row['kunci'];
                        $iv = $row['iv'];
                        $stegano_image = $row['steganografi_image'];
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $id_user; ?></td>
                            <td><?php echo $produk; ?></td>
                            <td>Rp<?php echo number_format($total_harga, 0, ',', '.'); ?></td>
                            <td><?php echo $status; ?></td>
                            <td>
                                <?php if ($bukti_pembayaran) { ?>
                                    <form method="POST" action="lihat_bukti.php" target="_blank">
                                        <input type="hidden" name="bukti_pembayaran" value="<?php echo $bukti_pembayaran; ?>">
                                        <input type="hidden" name="kunci" value="<?php echo $kunci; ?>">
                                        <input type="hidden" name="iv" value="<?php echo $iv; ?>">
                                        <button type="submit" class="btn btn-link">Lihat Bukti</button>
                                    </form>
                                <?php } else { ?>
                                    Belum diupload
                                <?php } ?>
                            </td>
                            <td>
                                <form method="POST" action="update_status.php">
                                    <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi; ?>">
                                    <select name="status" class="form-select mb-2" required>
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="Dikirim">Dikirim</option>
                                        <option value="Batal">Batal</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </form>
                            </td>
                            <td>
                                <?php if ($stegano_image) { ?>
                                    <form method="POST" action="">
                                        <input type="hidden" name="stegano_image" value="<?php echo $stegano_image; ?>">
                                        <button type="submit" name="decrypt" class="btn btn-warning btn-sm">Dekripsi Pesan</button>
                                    </form>
                                <?php } else { ?>
                                    Tidak Ada Pesan
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="alert alert-info">Belum ada transaksi.</div>
        <?php endif; ?>
        <a href="main_admin.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
    </div>

    <!-- Tambahkan PHP untuk Dekripsi -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['decrypt'])) {
        include('steganography_functions.php'); // Fungsi untuk dekripsi steganografi
        $stegano_image = $_POST['stegano_image'];
        $decrypted_message = decryptImage($stegano_image);

        if ($decrypted_message) {
            echo "<div class='alert alert-info mt-3'><strong>Pesan Tersembunyi:</strong> " . htmlspecialchars($decrypted_message) . "</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Gagal mendekripsi pesan.</div>";
        }
    }
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
