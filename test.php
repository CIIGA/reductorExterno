<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Generador de QR</title>
  <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
</head>
<body>


<?php
function encryptText($text, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($text, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

function decryptText($encryptedText, $key) {
    $data = base64_decode($encryptedText);
    $iv = substr($data, 0, openssl_cipher_iv_length('aes-256-cbc'));
    $decrypted = openssl_decrypt(substr($data, openssl_cipher_iv_length('aes-256-cbc')), 'aes-256-cbc', $key, 0, $iv);
    return $decrypted;
}

// Ejemplo de uso
$originalText = 'Texto confidencial';
$encryptionKey = 'ClaveSecreta123';

// Cifrar el texto
$encryptedText = encryptText($originalText, $encryptionKey);

echo 'Texto original: ' . $originalText . '<br>';
echo 'Texto cifrado: ' . $encryptedText . '<br>';

// Descifrar el texto
$decryptedText = decryptText($encryptedText, $encryptionKey);

echo 'Texto descifrado: ' . $decryptedText . '<br>';

?>





</body>
</html>