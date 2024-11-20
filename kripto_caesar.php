<?php
// Fungsi untuk mengenkripsi teks menggunakan Caesar Cipher
function caesarEncrypt($text, $keyCaesar) {
    $result = '';  // String untuk menyimpan hasil enkripsi

    // Loop untuk setiap karakter dalam teks
    for ($i = 0; $i < strlen($text); $i++) {
        if (ctype_upper($text[$i])) {  // Jika karakter adalah huruf besar
            // Enkripsi dengan pergeseran (key) dan mod 26 untuk tetap dalam huruf besar
            $result .= chr(((ord($text[$i]) + $keyCaesar - 65) % 26) + 65);
        } else if (ctype_lower($text[$i])) {  // Jika karakter adalah huruf kecil
            // Enkripsi dengan pergeseran (key) dan mod 26 untuk tetap dalam huruf kecil
            $result .= chr(((ord($text[$i]) + $keyCaesar - 97) % 26) + 97);
        } else {  // Jika karakter bukan huruf (misalnya spasi atau simbol)
            $result .= $text[$i];  // Tambahkan karakter tanpa perubahan
        }
    }

    return $result;  // Kembalikan hasil enkripsi
}

// Fungsi untuk mendekripsi teks menggunakan Caesar Cipher
function caesarDecrypt($text, $keyCaesar) {
    // Panggil fungsi enkripsi dengan kunci yang diubah (26 - (key % 26)) untuk mendekripsi
    return caesarEncrypt($text, 26 - ($keyCaesar % 26));
}
