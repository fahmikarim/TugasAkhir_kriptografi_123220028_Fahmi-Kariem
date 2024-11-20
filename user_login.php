<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="images/img-logo.png" type="image/png">
</head>

<body style="background-color: #3C6255;">
    <!-- Notifikasi Login -->
    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "gagal") {
            // header("location:login.php?pesan=login_gagal");
        } else if ($_GET['pesan'] == "logout") {
            // header("location:login.php?pesan=logout");
        } else if ($_GET['pesan'] == "belum_login") {
            // header("location:login.php?pesan=belum_login");
        }
    }
    ?>
    <!-- End notofikasi login -->

    <!-- Login Page -->
    <!-- Main Container -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <!-- Login Container -->
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <!-- Left Content -->
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #A6BB8D;">
                <div class="featured-image mb-3">
                    <img src="images/img-login.png" class="img-fluid" style="width: 250px;">
                </div>
                <p class="text-white fs-2 text-center" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">
                    Nerdy Store
                </p>
                <small class="text-white text-wrap text-center" style="width: 17 rem; font-family: 'Courier New', Courier, monospace;">Menyediakan buku dengan berbagai macam varian.</small>
            </div>
            <!-- Right Content -->
            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2>Welcome My Friend!</h2>
                        <p>Glad to See You</p>
                        <form action="cek_login_user.php" method="POST">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Username" name="username" required>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" name="password" required>
                            </div>
                            <div class="input-group mb-3">
                                <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                            </div>
                        </form>
                        <div class="row">
                            <small>Belum punya akun? <a href="user_daftar.php">Daftar</a></small>
                        </div>
                        <div class="row">
                        <small>Anda Admin? <a href="admin_login.php">Login Admin</a></small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Login Page-->
</body>

</html>