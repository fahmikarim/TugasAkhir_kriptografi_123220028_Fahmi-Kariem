<?php
include('aes.php'); // Pastikan fungsi encryptFile dan decryptFile tersedia

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $encrypted_file = $_POST['bukti_pembayaran']; // Nama file terenkripsi (jalur lengkap)
    $key = $_POST['kunci']; // Kunci yang digunakan untuk enkripsi
    $iv = $_POST['iv']; // IV dalam format hex dari proses enkripsi

    // Tentukan jalur untuk file hasil dekripsi
    $decrypted_file = 'uploads/decrypted_file.pdf'; // Ganti dengan jalur penyimpanan hasil dekripsi

    // Lakukan proses dekripsi
    $success = decryptFile($encrypted_file, $decrypted_file, $key, $iv);

    // Cek hasil dekripsi
    if ($success) {
        // Redirect ke file PDF hasil dekripsi
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($decrypted_file) . '"');
        readfile($decrypted_file);
        exit; // Menghentikan eksekusi lebih lanjut setelah file ditampilkan
    } else {
        echo "Gagal melakukan dekripsi. Periksa kembali parameter yang diberikan.";
    }
}
?>
