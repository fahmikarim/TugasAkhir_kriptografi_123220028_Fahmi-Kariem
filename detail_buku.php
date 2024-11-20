<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:user_login.php?pesan=belum_login");
}

include('koneksi.php');

// Ambil ID buku dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

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
    <title>Detail Buku - Nerdy Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="images/img-logo.png" type="image/png">
    <link rel="stylesheet" href="style.css">
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
    <!-- Navar -->
    <nav class="navbar fixed-top navbar-dark" style="background: #3C6255;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center " href="#" style="font-family: 'Courier New', Courier, monospace;">
                <img src="images/img-logo.png" alt="Logo" width="40" height="40" class=" me-2">
                Nerdy Store
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel" style="background: #61876E;">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title text-white" id="offcanvasDarkNavbarLabel" style="font-family: 'Courier New', Courier, monospace;">Nerdy Store</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex mt-3" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-success me-2" type="submit">Search</button>
                    </form>
                    <!-- Tombol Logout -->
                    <form action="logout.php" method="POST" class="mt-3">
                        <button class="btn btn-danger w-100" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- End Navbar -->

    <!-- Detail Section -->
    <div class="container detail-container">
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $cover; ?>" alt="Cover Buku" class="cover-image">
            </div>
            <div class="col-md-8">
                <h1 class="detail-title"><?php echo $judul; ?></h1>
                <p><strong>Penulis:</strong> <?php echo $penulis; ?></p>
                <p><strong>Penerbit:</strong> <?php echo $penerbit; ?></p>
                <p><strong>Tahun Terbit:</strong> <?php echo $tahun_terbit; ?></p>
                <p><strong>Kategori:</strong> <?php echo $kategori; ?></p>
                <p><strong>Harga:</strong> Rp<?php echo number_format($harga, 0, ',', '.'); ?></p>
                <p><strong>Stok:</strong> <?php echo $stok; ?></p>
                <p><strong>Deskripsi:</strong> <?php echo $deskripsi; ?></p>
                <a href="main_user.php" class="btn btn-success">Kembali ke Daftar Buku</a>
            </div>
        </div>
    </div>
    <!-- End Detail Section -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
