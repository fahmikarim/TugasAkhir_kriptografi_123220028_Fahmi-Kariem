<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:user_login.php?pesan=belum_login");
    exit();
}

include('koneksi.php');
include('steganography_functions.php'); // Fungsi Steganografi

$username = $_SESSION['username'];
$query = "
    SELECT transaksi.* 
    FROM transaksi 
    JOIN user ON transaksi.id_user = user.id_user
    WHERE user.username = '$username'
";
$result = $connect->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi Anda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="images/img-logo.png" type="image/png">
</head>

<body style="background: #f8f9fa;">
    <!-- Header -->
    <header class="bg-primary text-white py-3 shadow">
        <div class="container text-center">
            <h1 class="h4 mb-0">Data Transaksi Anda</h1>
        </div>
    </header>

    <!-- Konten -->
    <div class="container my-5">
        <?php if ($result->num_rows > 0) : ?>
            <div class="card shadow-lg">
                <div class="card-header bg-secondary text-white text-center">
                    <h5 class="mb-0">Riwayat Transaksi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
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
                                $no = 1;
                                while ($row = $result->fetch_assoc()) {
                                    $id_transaksi = $row['id_transaksi'];
                                    $produk = $row['judul_buku'];
                                    $total_harga = $row['total_harga'];
                                    $status = $row['status'];
                                    $bukti_pembayaran = $row['bukti_pembayaran'];
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($produk); ?></td>
                                        <td>Rp<?php echo number_format($total_harga, 0, ',', '.'); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo ($status === 'Dikirim') ? 'info' : (($status === 'Diterima') ? 'success' : 'warning'); ?>">
                                                <?php echo $status; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($bukti_pembayaran) { ?>
                                                <a href="uploads/<?php echo $bukti_pembayaran; ?>" class="btn btn-link btn-sm" target="_blank">Lihat Bukti</a>
                                            <?php } else { ?>
                                                <span class="text-muted">Belum diupload</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if (!$bukti_pembayaran && $status === 'Pending') { ?>
                                                <form method="POST" enctype="multipart/form-data" action="upload_bukti.php">
                                                    <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi; ?>">
                                                    <input type="file" name="bukti_pembayaran" class="form-control form-control-sm mb-2" required>
                                                    <button type="submit" class="btn btn-success btn-sm">Upload</button>
                                                </form>
                                            <?php } elseif ($status === 'Dikirim') { ?>
                                                <form method="POST" action="update_status_user.php">
                                                    <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi; ?>">
                                                    <input type="hidden" name="status" value="Diterima">
                                                    <button type="submit" class="btn btn-primary btn-sm">Konfirmasi Diterima</button>
                                                </form>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <form method="POST" enctype="multipart/form-data" action="steganography_upload.php">
                                                <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi; ?>">
                                                <textarea name="message" class="form-control form-control-sm mb-2" placeholder="Pesan untuk admin" required></textarea>
                                                <input type="file" name="image" class="form-control form-control-sm mb-2" accept="image/png" required>
                                                <button type="submit" class="btn btn-warning btn-sm">Kirim Pesan</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="alert alert-warning text-center shadow" role="alert">
                <h5 class="alert-heading">Belum Ada Transaksi</h5>
                <p class="mb-0">Anda belum melakukan transaksi. <a href="main_user.php" class="alert-link">Belanja sekarang!</a></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tombol Kembali -->
    <div class="container text-center">
        <a href="main_user.php" class="btn btn-secondary w-100 shadow">Kembali ke Halaman Utama</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
