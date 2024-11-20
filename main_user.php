<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:user_login.php?pesan=belum_login");
}

// Ambil id_user dari sesi
$_SESSION['username'];
$kunci1 = 21;
$kunci2 = "kripto menyenangkan";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerdy Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="images/img-logo.png" type="image/png">
    <link rel="stylesheet" href="style.css">
</head>

<body style="background: #E2F1E7;">
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
                            <a class="nav-link active" aria-current="page" href="main_user.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="keranjang.php">Keranjang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="transaksi_user.php">Transaksi</a>
                        </li>
                        <!-- Data Diri -->
                        <li class="nav-item">
                            <a class="nav-link" href="#viewUserModal" data-bs-toggle="modal" data-bs-target="#viewUserModal" aria-controls="offcanvasDataDiri">Data Diri</a>
                        </li>
                        <!-- End Data Diri -->
                        </li>
                    </ul>
                    <!-- Tombol Logout -->
                    <form action="logout.php" method="POST" class="mt-3">
                        <button class="btn btn-danger w-100" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- End Navbar -->

    <!-- Modal Data user -->
    <!-- Modal Tampilkan Data User -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewUserModalLabel">Data Diri User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    include('koneksi.php');
                    include('kripto_superEnkripsi.php');
                    $query_user = "SELECT * FROM user WHERE username = '" . $_SESSION['username'] . "';";
                    $result_user = $connect->query($query_user);

                    if ($result_user->num_rows > 0) {
                        $data_user = $result_user->fetch_assoc();
                        $cover = 'uploads/' . $data_user['profil_picture'];
                    ?>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <?php
                                    // Check if the image file exists
                                    if (file_exists($cover)) {
                                        echo "<img src='$cover' alt='Profile Picture' style='width: 50px; height: 50px;'>";
                                    } else {
                                        echo "No image available";
                                    }
                                    ?>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Nama</strong>
                                <span><?php echo htmlspecialchars(superDekripsi($data_user['nama'], $kunci1, $kunci2)); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Username</strong>
                                <span><?php echo htmlspecialchars($data_user['username']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Jenis Kelamin</strong>
                                <span><?php echo htmlspecialchars(superDekripsi($data_user['jenis_kelamin'], $kunci1, $kunci2)); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Alamat</strong>
                                <span><?php echo htmlspecialchars(superDekripsi($data_user['alamat'], $kunci1, $kunci2)); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Telepon</strong>
                                <span><?php echo htmlspecialchars(superDekripsi($data_user['telepon'], $kunci1, $kunci2)); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Tempat Lahir</strong>
                                <span><?php echo htmlspecialchars(superDekripsi($data_user['tempat_lahir'], $kunci1, $kunci2)); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Tanggal Lahir</strong>
                                <span><?php echo date("d M Y", strtotime(superDekripsi($data_user['tanggal_lahir'], $kunci1, $kunci2))); ?></span>
                            </li>
                        </ul>

                    <?php
                    } else {
                        echo "<p>Data user tidak ditemukan.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- End Modal data user -->

    <!-- Title -->
    <!-- Title Section -->
    <div class="container text-center mt-5 pt-5">
        <h1 class="title">Nerdy Book Store</h1>
        <p class="text-muted">Not Just An Ordinary Store Books</p>
    </div>
    <!-- End Title -->

    <!-- Card -->
    <?php

    include('koneksi.php');

    $query = "SELECT * FROM buku";
    $result = $connect->query($query);
    ?>

    <div class="container">
        <div class="row row-cols-1 row-cols-md-4 g-4"> <!-- row-cols-md-4 makes 4 cards per row on medium screens and larger -->
            <?php
            // Assuming $result contains the books from the database
            if ($result->num_rows > 0) {
                // Loop through each book and display it as a card
                while ($row = $result->fetch_assoc()) {
                    $judul = $row['judul'];
                    $deskripsi = $row['deskripsi'];
                    $harga = $row['harga'];
                    $cover = 'uploads/' . $row['cover']; // Assuming cover images are stored in the 'uploads/' folder
            ?>
                    <div class="col"> <!-- Each card is inside a column, and it will take up 1/4 of the row's width on medium screens -->
                        <a href="detail_buku.php?id=<?php echo $row['id_buku']; ?>" class="text-decoration-none text-dark">
                            <div class="card text-center shadow p-1" style="background: #C6D9D0;">
                                <img src="<?php echo $cover; ?>" class="img-thumbnail cover mx-auto d-block" alt="Cover Buku">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $judul; ?></h5>
                                    <p class="card-text"><?php echo substr($deskripsi, 0, 50) . (strlen($deskripsi) > 50 ? '...' : ''); ?></p>
                                    <h5 class="card-title">Rp<?php echo number_format($harga, 0, ',', '.'); ?></h5>
                                    <a href="tambah_ke_keranjang.php?id=<?php echo $row['id_buku']; ?>" class="btn btn-danger">Add To Cart</a>
                                </div>
                            </div>
                        </a>
                    </div>
            <?php
                }
            }
            $connect->close();
            ?>
        </div>
    </div>


    <!-- end card -->
    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>