<?php

class RSA
{
    private $publicKey;
    private $privateKey;
    private $keyLength;

    public function __construct($keyLength = 1024)
    {
        $this->keyLength = $keyLength;
        $this->generateKeys();
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    public function encrypt($message, $publicKey)
    {
        openssl_public_encrypt($message, $encrypted, $publicKey);
        return base_encode($encrypted);
    }

    public function decrypt($encryptedMessage, $privateKey)
    {
        $encryptedMessage = base64_decode($encryptedMessage);
        openssl_private_decrypt($encryptedMessage, $decrypted, $privateKey);
        return $decrypted;
    }

    private function generateKeys()
    {
        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => $this->keyLength,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );

        // Generate the key pair
        $keyPair = openssl_pkey_new($config);

        // Get private key
        openssl_pkey_export($keyPair, $privateKey);

        // Get public key
        $publicKeyDetails = openssl_pkey_get_details($keyPair);
        $publicKey = $publicKeyDetails['key'];

        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }
}

// Example usage:

// Instantiate RSA class with a key length of 1024 bits
$rsa = new RSA(1024);

// Get public and private keys
$publicKey = $rsa->getPublicKey();
$privateKey = $rsa->getPrivateKey();

// Message to be encrypted
$message = "Hello, RSA encryption!";

// Encrypt the message using the public key
$encryptedMessage = $rsa->encrypt($message, $publicKey);
echo "Encrypted Message: " . $encryptedMessage . PHP_EOL;

// Decrypt the message using the private key
$decryptedMessage = $rsa->decrypt($encryptedMessage, $privateKey);
echo "Decrypted Message: " . $decryptedMessage . PHP_EOL;
?>