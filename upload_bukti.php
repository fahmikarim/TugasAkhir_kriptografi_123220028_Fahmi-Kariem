<?php
include('koneksi.php');
include('aes.php'); // File yang berisi fungsi enkripsi dan dekripsi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_transaksi = $_POST['id_transaksi'];
    $target_dir = "uploads/"; // Direktori penyimpanan file
    $file_name = basename($_FILES["bukti_pembayaran"]["name"]);
    $file_temp = $_FILES["bukti_pembayaran"]["tmp_name"];
    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $upload_ok = 1;

    // Validasi file
    $check = getimagesize($file_temp);
    if ($check !== false || $file_type == "pdf") {
        $upload_ok = 1;
    } else {
        echo "File yang diunggah bukan gambar atau PDF.";
        $upload_ok = 0;
    }

    // Cek ukuran file (maksimal 2MB)
    if ($_FILES["bukti_pembayaran"]["size"] > 2000000) {
        echo "Ukuran file terlalu besar.";
        $upload_ok = 0;
    }

    // Batasi format file yang diizinkan
    if (!in_array($file_type, ["jpg", "png", "jpeg", "pdf"])) {
        echo "Hanya format JPG, JPEG, PNG, dan PDF yang diperbolehkan.";
        $upload_ok = 0;
    }

    if ($upload_ok == 1) {
        // Proses enkripsi
        $encrypted_file = $target_dir . uniqid("enc_") . ".enc"; // Nama file terenkripsi
        $key = bin2hex(random_bytes(16)); // Kunci AES (16 bytes = 128-bit)

        // Enkripsi file
        $iv = encryptFile($file_temp, $encrypted_file, $key); //initialization verctor

        if ($iv) {
            // Update nama file dan kunci enkripsi ke database
            $query = "UPDATE transaksi SET bukti_pembayaran = ?, kunci = ?, iv = ? WHERE id_transaksi = ?";
            $stmt = $connect->prepare($query);
            $stmt->bind_param("ssss", $encrypted_file, $key, $iv, $id_transaksi);

            if ($stmt->execute()) {
                echo "Bukti pembayaran berhasil diunggah dan terenkripsi.";
                header("Location: main_user.php"); // Redirect ke halaman transaksi user
            } else {
                echo "Gagal memperbarui database.";
            }
        } else {
            echo "Terjadi kesalahan saat mengenkripsi file.";
        }
    } else {
        echo "File tidak valid untuk diunggah.";
    }
}
?>
