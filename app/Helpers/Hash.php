<?php

namespace PhpYourAdimn\App\Helpers;

class Hash
{
    /**
     * Algorithm for performing encryption and decryption
     * 
     * @var string CIPHERING
     */
    private const CIPHERING = "AES-128-CTR";

    /**
     * Random number that guarantees the encrypted text is unique
     * 
     * @var string ENCRYPTION_IV
     */
    private const ENCRYPTION_IV = "1234567891011121";

    /**
     * Use openssl_encrypt() function to encrypt the data
     * 
     * @param string $string
     * @return string encrypted string
     */
    public static function encrypt(string $string): string
    {
        $simpleString = $string;

        $ciphering = self::CIPHERING;

        $iv_length = openssl_cipher_iv_length($ciphering);

        $options = 0;

        $encryptionIv = self::ENCRYPTION_IV;

        $encryptionKey = getenv("ENCRYPTION_KEY");

        $encryption = openssl_encrypt(
            $simpleString,
            $ciphering,
            $encryptionKey,
            $options,
            $encryptionIv
        );
        return $encryption;
    }

    /**
     * Use openssl_decrypt() function to decrypt the data
     * 
     * @param string $string encrypted
     * @return string decrypted string
     */
    public static function decrypt(string $string): string
    {
        $encryption = $string;

        $ciphering = self::CIPHERING;

        $options = 0;

        $decryptionIv = self::ENCRYPTION_IV;

        $decryptionKey = getenv("ENCRYPTION_KEY");

        $decryption = openssl_decrypt(
            $encryption,
            $ciphering,
            $decryptionKey,
            $options,
            $decryptionIv
        );
        return $decryption;
    }
}
