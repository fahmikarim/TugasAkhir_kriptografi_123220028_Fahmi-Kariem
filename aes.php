<?php

function encryptFile($inputPath, $outputPath, $key) {
    if (!file_exists($inputPath)) {
        return null; 
    }
    $iv = random_bytes(16); 
    $data = file_get_contents($inputPath);
    $encryptedData = openssl_encrypt
    ($data, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    if ($encryptedData === false) {
        return null; 
    }
    $finalData = $iv . $encryptedData;
    file_put_contents($outputPath, $finalData);
    return bin2hex($iv);
}

function decryptFile($inputPath, $outputPath, $key, $iv) {
    if (!file_exists($inputPath)) {
        return false; 
    }
    $data = file_get_contents($inputPath); 
    $iv = hex2bin($iv); 
    $encryptedData = substr($data, 16); 
    $decryptedData = openssl_decrypt
    ($encryptedData, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    if ($decryptedData === false) {
        return false; 
    }
    file_put_contents($outputPath, $decryptedData); 
    return true;
}
?>