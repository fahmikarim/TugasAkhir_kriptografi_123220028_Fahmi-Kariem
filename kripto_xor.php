<?php
// Fungsi untuk mengubah karakter ke dalam bentuk karakter umum (printable ASCII)
function toCommonCharacter($common) {
    // Menghitung karakter umum dengan menggunakan modulus 95 dan menambahkan 32
    return chr(($common % 95) + 32); // Hasilkan karakter dalam rentang printable ASCII (32-126)
}

// Fungsi untuk mengenkripsi dan mendekripsi teks menggunakan XOR
function encryptDecryptXOR($text, $keyXor) {
    $result = $text;  // Buat salinan dari teks input untuk menyimpan hasil
    $keyLength = strlen($keyXor);  // Panjang kunci
    
    // Loop untuk setiap karakter dalam teks
    for ($i = 0; $i < strlen($text); $i++) {
        // Lakukan operasi XOR antara karakter teks dan kunci, lalu ubah hasilnya ke karakter umum
        $result[$i] = toCommonCharacter(ord($text[$i]) ^ ord($keyXor[$i % $keyLength]));
    }
    
    return $result;  // Kembalikan hasil enkripsi atau dekripsi
}
