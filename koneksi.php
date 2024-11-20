<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "toko_buku_kripto";

    $connect = new mysqli($hostname, $username, $password, $database);
    if($connect->connect_error){
        die('Maaf Koneksi gagal: '. $connect->connect_error);
    }
?>