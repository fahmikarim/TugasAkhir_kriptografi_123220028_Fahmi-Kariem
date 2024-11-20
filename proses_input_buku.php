
<?php
session_start();

include('koneksi.php');
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    // Handle file upload for cover image
    $cover = $_FILES['cover'];
    $cover_name = $cover['name'];
    $cover_tmp_name = $cover['tmp_name'];
    $cover_size = $cover['size'];
    $cover_error = $cover['error'];

    // Check if there is an error with the uploaded file
    if ($cover_error === 0) {
        // Get file extension and check if it's an image
        $file_extension = strtolower(pathinfo($cover_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_extension, $allowed_extensions)) {
            // Generate a unique file name and move the file to the "uploads" directory
            $new_cover_name = uniqid('', true) . '.' . $file_extension;
            $upload_dir = 'uploads/';
            $upload_path = $upload_dir . $new_cover_name;

            if (move_uploaded_file($cover_tmp_name, $upload_path)) {
                // Insert data into the database
                $sql = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, kategori, harga, stok, deskripsi, cover) 
                        VALUES ('$judul', '$penulis', '$penerbit', '$tahun_terbit', '$kategori', '$harga', '$stok', '$deskripsi', '$new_cover_name')";

                if ($connect->query($sql) === TRUE) {
                    header("location:main_admin.php?pesan=input_berhasil");
                    echo "Buku berhasil ditambahkan!";
                } else {
                    echo "Error: " . $sql . "<br>" . $connect->error;
                }
            } else {
                echo "Gagal mengupload cover buku.";
            }
        } else {
            echo "Ekstensi file tidak valid. Hanya file gambar yang diperbolehkan.";
        }
    } else {
        echo "Terjadi kesalahan saat mengupload file.";
    }
}

// Close database connection
$connect->close();
?>