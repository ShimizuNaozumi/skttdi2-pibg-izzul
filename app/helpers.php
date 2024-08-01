<?php

// Encryption
if (!function_exists('encrypt_string')) {
    function encrypt_string($value)
    {
        $encrypted = openssl_encrypt($value, 'AES-128-ECB', 'epikm');
        return base64_encode($encrypted);
    }
}

// Decryption
if (!function_exists('decrypt_string')) {
    function decrypt_string($encryptedValue)
    {
        $decoded = base64_decode($encryptedValue);
        $decrypted = openssl_decrypt($decoded, 'AES-128-ECB', 'epikm');
        return $decrypted;
    }
}