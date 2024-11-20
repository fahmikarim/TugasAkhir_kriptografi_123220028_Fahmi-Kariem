<?php

function encryptImage($imagePath, $message, $outputImagePath) {
    $image = imagecreatefrompng($imagePath);
    if (!$image) return "Failed to open image.";

    $width = imagesx($image);
    $height = imagesy($image);

    $binaryMessage = toBinary($message) . '00000000'; // Tambahkan null byte sebagai delimiter
    $messageIndex = 0;

    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            if ($messageIndex >= strlen($binaryMessage)) break 2;

            $rgb = imagecolorat($image, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            // Sisipkan 1 bit pesan ke LSB channel biru
            $b = ($b & 0xFE) | $binaryMessage[$messageIndex];
            $messageIndex++;

            $newColor = imagecolorallocate($image, $r, $g, $b);
            imagesetpixel($image, $x, $y, $newColor);
        }
    }

    imagepng($image, $outputImagePath); // Simpan gambar dengan pesan tersembunyi
    imagedestroy($image);
    return "Message successfully embedded into the image!";
}

function decryptImage($imagePath) {
    $image = imagecreatefrompng($imagePath);
    if (!$image) return "Failed to open image.";

    $width = imagesx($image);
    $height = imagesy($image);

    $binaryMessage = '';

    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $rgb = imagecolorat($image, $x, $y);
            $b = $rgb & 0xFF;

            // Ambil LSB dari channel biru
            $binaryMessage .= $b & 1;

            // Jika menemukan null byte (delimiter), hentikan
            if (substr($binaryMessage, -8) === '00000000') break 2;
        }
    }

    $message = fromBinary(substr($binaryMessage, 0, -8)); // Hilangkan delimiter null byte
    imagedestroy($image);
    return $message;
}

function toBinary($text) {
    $binary = '';
    for ($i = 0; $i < strlen($text); $i++) {
        $binary .= str_pad(decbin(ord($text[$i])), 8, '0', STR_PAD_LEFT);
    }
    return $binary;
}

function fromBinary($binary) {
    $text = '';
    for ($i = 0; $i < strlen($binary); $i += 8) {
        $text .= chr(bindec(substr($binary, $i, 8)));
    }
    return $text;
}
?>
