<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:user_login.php?pesan=belum_login");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nerdy Store Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="images/img-logo.png" type="image/png">
    <link rel="stylesheet" href="style.css">
</head>

<body style="background: #E2F1E7;">
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-dark" style="background: #3C6255;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#" style="font-family: 'Courier New', Courier, monospace;">
                <img src="images/img-logo.png" alt="Logo" width="40" height="40" class="me-2">
                Nerdy Store Admin
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
                            <a class="nav-link" data-bs-toggle="modal" href="#inputBukuModal">Input Buku</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="transaksi_admin.php">Transaksi</a>
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

    <!-- Modal for Input Buku Form -->
    <div class="modal fade" id="inputBukuModal" tabindex="-1" aria-labelledby="inputBukuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputBukuModalLabel">Input Buku Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" action="proses_input_buku.php">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="penulis" class="form-label">Penulis</label>
                            <input type="text" class="form-control" id="penulis" name="penulis" required>
                        </div>
                        <div class="mb-3">
                            <label for="penerbit" class="form-label">Penerbit</label>
                            <input type="text" class="form-control" id="penerbit" name="penerbit" required>
                        </div>
                        <div class="mb-3">
                            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="cover" class="form-label">Cover Buku</label>
                            <input type="file" class="form-control" id="cover" name="cover" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Tambah Buku</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Form -->

    <!-- Title Section -->
    <div class="container text-center mt-5 pt-5">
        <h1 class="title">Nerdy Book Store Admin</h1>
        <p class="text-muted">Your 'Not Just An Ordinary Store Books'</p>
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
                        <a href="detail_buku_admin.php?id=<?php echo $row['id_buku']; ?>" class="text-decoration-none text-dark">
                            <div class="card text-center shadow p-1" style="background: #C6D9D0;">
                                <img src="<?php echo $cover; ?>" class="img-thumbnail cover mx-auto d-block" alt="Cover Buku">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $judul; ?></h5>
                                    <p class="card-text"><?php echo substr($deskripsi, 0, 50) . (strlen($deskripsi) > 50 ? '...' : ''); ?></p>
                                    <h5 class="card-title">Rp<?php echo number_format($harga, 0, ',', '.'); ?></h5>
                                    <!-- Form Delete -->
                                    <form method="POST" action="delete_buku.php" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        <input type="hidden" name="id_buku" value="<?php echo $row['id_buku']; ?>">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>

</html>