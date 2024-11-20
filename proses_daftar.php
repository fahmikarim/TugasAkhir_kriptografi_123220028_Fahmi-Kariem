<?php
// Memulai sesi
session_start();

// Menyertakan file koneksi ke database
include 'koneksi.php';
include 'kripto_superEnkripsi.php';

// Menangkap data dari form
$nama = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$alamat = $_POST['alamat'];
$telepon = $_POST['telepon'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$profil_picture = "";

// Hashing password menggunakan MD5
$hashed_password = md5($password);

//Enkripsi Data Konsumen
$nama = superEnkripsi($nama, 21, "kripto menyenangkan");
$jenis_kelamin = superEnkripsi($jenis_kelamin, 21, "kripto menyenangkan");
$alamat = superEnkripsi($alamat, 21, "kripto menyenangkan");
$telepon = superEnkripsi($telepon, 21, "kripto menyenangkan");
$tempat_lahir = superEnkripsi($tempat_lahir, 21, "kripto menyenangkan");
$tanggal_lahir = superEnkripsi($tanggal_lahir, 21, "kripto menyenangkan");


// Proses upload gambar profil
if (isset($_FILES['profil_picture']) && $_FILES['profil_picture']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profil_picture']['tmp_name'];
    $fileName = $_FILES['profil_picture']['name'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    if (in_array($fileExtension, $allowedExtensions)) {
        $uploadFileDir = 'uploads/';
        $newFileName = uniqid() . '.' . $fileExtension;
        $destPath = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $profil_picture = $newFileName;
        } else {
            die("Error: Gagal mengunggah gambar profil.");
        }
    } else {
        die("Error: Ekstensi file tidak diperbolehkan. Hanya JPG, JPEG, dan PNG yang diizinkan.");
    }
} else {
    $profil_picture = 'default.png'; // Jika tidak ada gambar, gunakan gambar default
}

// Validasi username unik
$query = "SELECT * FROM user WHERE username = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Error: Username sudah digunakan. Silakan pilih username lain.");
}

// Menyimpan data ke database
$query = "INSERT INTO user (username, password, nama, jenis_kelamin, alamat, telepon, tempat_lahir, tanggal_lahir, profil_picture) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $connect->prepare($query);
$stmt->bind_param("sssssssss", $username, $hashed_password, $nama, $jenis_kelamin, $alamat, $telepon, $tempat_lahir, $tanggal_lahir, $profil_picture);

if ($stmt->execute()) {
    header("location:main_user.php?pesan=daftar_berhasil");
    echo "Pendaftaran berhasil! Silakan <a href='user_login.php'>login</a>.";
} else {
    echo "Error: " . $stmt->error;
}

// Menutup koneksi
$stmt->close();
$connect->close();
?>
