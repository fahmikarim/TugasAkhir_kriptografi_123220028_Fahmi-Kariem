<?php
session_start();
include 'koneksi.php';

// Menghubungkan ke database dengan MySQLi
$query = new mysqli($hostname, $username, $password, $database);

// Menangkap data dari form login
$username = $_POST['username'];
$password = $_POST['password'];

// Menggunakan prepared statement untuk mencegah SQL injection
$stmt = $query->prepare("SELECT id_user, username, password FROM user WHERE username = ?");
$stmt->bind_param("s", $username); // Mengikat parameter (s = string)
$stmt->execute();
$result = $stmt->get_result();

// Mengecek apakah username ditemukan di database
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verifikasi password yang di-hash dengan MD5 dan password yang dimasukkan
    if (md5($password) == $row['password']) {
        // Jika login berhasil
        $_SESSION['id_user'] = $row['id_user']; // Menggunakan $row['id_user'] langsung
        $_SESSION['username'] = $username;
        $_SESSION['status'] = "login";
        header("location:main_user.php");
    } else {
        // Jika password salah
        header("location:user_login.php?pesan=login_gagal");
    }
} else {
    // Jika username tidak ditemukan
    header("location:user_login.php?pesan=login_gagal");
}

// Menutup koneksi
$stmt->close();
$query->close();
