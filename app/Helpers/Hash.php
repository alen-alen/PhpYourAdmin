<?php

namespace PhpYourAdimn\App\Helpers;

class Hash
{

    const CIPHERING = "AES-128-CTR";

    const ENCRYPTION_IV = "1234567891011121";

    public static function encrypt($string)
    {
        $simple_string = $string;

        $ciphering = self::CIPHERING;

        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Non-NULL Initialization Vector for encryption
        $encryption_iv = self::ENCRYPTION_IV;

        // Store the encryption key
        $encryption_key = getenv("ECNRYPTION_KEY");

        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt(
            $simple_string,
            $ciphering,
            $encryption_key,
            $options,
            $encryption_iv
        );

        return $encryption;
    }

    public static function decrypt($string)
    {
        $encryption = $string;

        $ciphering = self::CIPHERING;

        $options = 0;

        // Non-NULL Initialization Vector for decryption
        $decryption_iv = self::ENCRYPTION_IV;

        // Store the decryption key
        $decryption_key = getenv("ECNRYPTION_KEY");

        // Use openssl_decrypt() function to decrypt the data
        $decryption = openssl_decrypt(
            $encryption,
            $ciphering,
            $decryption_key,
            $options,
            $decryption_iv
        );

        // Display the decrypted string

        return $decryption;
    }
}
