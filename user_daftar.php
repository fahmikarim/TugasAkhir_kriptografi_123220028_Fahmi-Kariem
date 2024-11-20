<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Daftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="images/img-logo.png" type="image/png">
</head>

<body style="background-color: #3C6255;">
    <!-- Main Container -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <!-- Daftar Container -->
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <!-- Left Content -->
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #A6BB8D;">
                <div class="featured-image mb-3">
                    <img src="images/img-voldy.png" class="img-fluid" style="width: 250px;">
                </div>
                <p class="text-white fs-2 text-center" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">
                    Nerdy Store
                </p>
                <small class="text-white text-wrap text-center" style="width: 17rem; font-family: 'Courier New', Courier, monospace;">
                    Bergabunglah bersama kami untuk menikmati berbagai pilihan buku terbaik.
                </small>
            </div>
            <!-- Right Content -->
            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <p class="text-center fw-bold">Registration Form</p>
                        <form action="proses_daftar.php" method="POST" enctype="multipart/form-data">
                            <!-- Username -->
                            <div class="input-group mb-2">
                                <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Username" name="username" required>
                            </div>
                            <!-- Password -->
                            <div class="input-group mb-2">
                                <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" name="password" required>
                            </div>
                            <!-- Nama -->
                            <div class="input-group mb-2">
                                <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Nama Lengkap" name="nama" required>
                            </div>
                            <!-- Jenis Kelamin -->
                            <div class="mb-2">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki" value="Laki-Laki" required>
                                    <label class="form-check-label" for="laki-laki">Laki-Laki</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan">
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                            </div>
                            <!-- Alamat -->
                            <div class="input-group mb-2">
                                <textarea class="form-control form-control-lg bg-light fs-6" placeholder="Alamat" name="alamat" rows="2" required></textarea>
                            </div>
                            <!-- Nomor Telepon -->
                            <div class="input-group mb-2">
                                <input type="tel" class="form-control form-control-lg bg-light fs-6" placeholder="Nomor Telepon" name="telepon" required>
                            </div>
                            <!-- Tempat Lahir -->
                            <div class="input-group mb-2">
                                <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Tempat Lahir" name="tempat_lahir" required>
                            </div>
                            <!-- Tanggal Lahir -->
                            <div class="input-group mb-2">
                                <input type="date" class="form-control form-control-lg bg-light fs-6" name="tanggal_lahir" required>
                            </div>
                            <!-- Profil Picture -->
                            <div class="input-group mb-2">
                                <input type="file" class="form-control form-control-lg bg-light fs-6" name="profil_picture" accept="image/*" required>
                            </div>
                            <!-- Tombol Submit -->
                            <div class="input-group mb-2">
                                <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Daftar</button>
                            </div>
                        </form>
                        <!-- Link Kembali ke Login -->
                        <div class="row">
                            <small>Sudah punya akun? <a href="user_login.php">Login</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>