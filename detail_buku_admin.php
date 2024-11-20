<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:user_login.php?pesan=belum_login");
}

include('koneksi.php');

// Ambil ID buku dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Jika form disubmit, perbarui data di database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    $updateQuery = "
        UPDATE buku 
        SET 
            judul = '$judul', 
            penulis = '$penulis', 
            penerbit = '$penerbit', 
            tahun_terbit = '$tahun_terbit', 
            kategori = '$kategori', 
            harga = $harga, 
            stok = $stok, 
            deskripsi = '$deskripsi'
        WHERE id_buku = $id
    ";

    if ($connect->query($updateQuery) === TRUE) {
        $successMessage = "Data buku berhasil diperbarui!";
    } else {
        $errorMessage = "Gagal memperbarui data: " . $connect->error;
    }
}

// Ambil data buku berdasarkan ID
$query = "SELECT * FROM buku WHERE id_buku = $id";
$result = $connect->query($query);

// Jika data ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $judul = $row['judul'];
    $penulis = $row['penulis'];
    $penerbit = $row['penerbit'];
    $tahun_terbit = $row['tahun_terbit'];
    $kategori = $row['kategori'];
    $harga = $row['harga'];
    $stok = $row['stok'];
    $deskripsi = $row['deskripsi'];
    $cover = 'uploads/' . $row['cover'];
} else {
    echo "Buku tidak ditemukan.";
    exit;
}
$connect->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Nerdy Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="images/img-logo.png" type="image/png">
    <style>
        .detail-container {
            margin-top: 100px;
            background: #F3F8F5;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .cover-image {
            max-width: 100%;
            border-radius: 10px;
        }

        .detail-title {
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            color: #3C6255;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-dark" style="background: #3C6255;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center " href="#" style="font-family: 'Courier New', Courier, monospace;">
                <img src="images/img-logo.png" alt="Logo" width="40" height="40" class="me-2">
                Nerdy Store
            </a>
        </div>
    </nav>
    <!-- End Navbar -->

    <div class="container detail-container">
        <h1 class="detail-title">Edit Buku</h1>

        <?php if (!empty($successMessage)) : ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <?php if (!empty($errorMessage)) : ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="row">
                <div class="col-md-4">
                    <img src="<?php echo $cover; ?>" alt="Cover Buku" class="cover-image">
                </div>
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $judul; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="penulis" class="form-label">Penulis</label>
                        <input type="text" class="form-control" id="penulis" name="penulis" value="<?php echo $penulis; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="penerbit" class="form-label">Penerbit</label>
                        <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo $penerbit; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                        <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="<?php echo $tahun_terbit; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" value="<?php echo $kategori; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $harga; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" value="<?php echo $stok; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required><?php echo $deskripsi; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    <a href="main_admin.php" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>