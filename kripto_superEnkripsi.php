<?php
    include 'kripto_caesar.php';
    include 'kripto_xor.php';

    function superEnkripsi($text, $keyCaesar, $keyXor){

        $caesarEnkripsi = caesarEncrypt($text, $keyCaesar);
        $xorEnkripsi = encryptDecryptXOR($caesarEnkripsi, $keyXor);

        return $xorEnkripsi;
    }

    function superDekripsi($text, $keyCaesar, $keyXor){
        $xorDekripsi = encryptDecryptXOR($text, $keyXor);
        $caesarDekripsi = caesarDecrypt($xorDekripsi, $keyCaesar);
        
        return $caesarDekripsi;
    }
?>