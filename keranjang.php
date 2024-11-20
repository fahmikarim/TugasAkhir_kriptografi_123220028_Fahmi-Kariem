<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:user_login.php?pesan=belum_login");
    exit();
}

include('koneksi.php');

// Ambil data keranjang dari sesi
$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
$total_harga = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="images/img-logo.png" type="image/png">
</head>

<body style="background: #f8f9fa;">

    <!-- Header -->
    <header class="bg-primary text-white py-3 shadow">
        <div class="container text-center">
            <h1 class="h3 mb-0">Keranjang Belanja</h1>
        </div>
    </header>

    <!-- Keranjang Belanja -->
    <div class="container my-5">
        <?php if (!empty($keranjang)) : ?>
            <div class="card shadow-lg">
                <div class="card-header bg-secondary text-white text-center">
                    <h5 class="mb-0">Detail Keranjang Anda</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>Judul Buku</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($keranjang as $id_buku => $jumlah) {
                                    // Ambil data buku dari database
                                    $query = "SELECT * FROM buku WHERE id_buku = $id_buku";
                                    $result = $connect->query($query);
                                    if ($row = $result->fetch_assoc()) {
                                        $judul = $row['judul'];
                                        $harga = $row['harga'];
                                        $subtotal = $harga * $jumlah;
                                        $total_harga += $subtotal;
                                ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($judul); ?></td>
                                            <td>Rp<?php echo number_format($harga, 0, ',', '.'); ?></td>
                                            <td><?php echo $jumlah; ?></td>
                                            <td>Rp<?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-light">
                                    <th colspan="3" class="text-end">Total</th>
                                    <th>Rp<?php echo number_format($total_harga, 0, ',', '.'); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <form action="checkout.php" method="POST" class="mt-3">
                        <button class="btn btn-success btn-lg w-100 shadow" type="submit">Checkout</button>
                    </form>
                </div>
            </div>
        <?php else : ?>
            <div class="alert alert-warning text-center shadow" role="alert">
                <h5 class="alert-heading">Keranjang Anda Kosong</h5>
                <p class="mb-0">Belum ada item di keranjang Anda. <a href="main_user.php" class="alert-link">Belanja sekarang!</a></p>
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
