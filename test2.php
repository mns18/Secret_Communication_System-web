<?php

// Function to encrypt an image
function encryptImage($inputImagePath, $outputImagePath, $key) {
    $inputData = file_get_contents($inputImagePath);
    $iv = openssl_random_pseudo_bytes(16);
    $encryptedData = openssl_encrypt($inputData, 'aes-256-cbc', $key, 0, $iv);
    file_put_contents($outputImagePath, $iv . $encryptedData);
}

// Function to decrypt an image
function decryptImage($inputImagePath, $outputImagePath, $key) {
    $encryptedData = file_get_contents($inputImagePath);
    $iv = substr($encryptedData, 0, 16);
    $encryptedData = substr($encryptedData, 16);
    $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
    file_put_contents($outputImagePath, $decryptedData);
}

// Example usage
$inputImage = 'image/website.jpg';
$encryptedImage = 'image/imageenc.enc';
$decryptedImage = 'image/image_decrypted.jpg';
$key = '12345';

// Encrypt the image
encryptImage($inputImage, $encryptedImage, $key);

// Decrypt the image
decryptImage($encryptedImage, $decryptedImage, $key);

// ?>