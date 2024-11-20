<?php
    session_start();
    include('koneksi.php');
    $query = new mysqli($hostname, $username, $password, $database);

    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = mysqli_query($query, "select * FROM admin where username = '$username' and password = '$password'");

    $cek = mysqli_num_rows($data);

    if ($cek > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['status'] = "login";
        header("location:main_admin.php");
    } else {
        header("location:admin_login.php?pesan=login_gagal");
    }