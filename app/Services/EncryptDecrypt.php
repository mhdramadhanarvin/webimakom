<?php

namespace App\Services;

class EncryptDecrypt
{
    protected static $method = "AES-256-CBC";
    protected static $key = "encryptionKey123";
    protected static $options = 0;
    protected static $iv = '1234567891011121';

    public static function encryptText($plainText): String
    {
        return openssl_encrypt($plainText, self::$method, self::$key, self::$options, self::$iv);
    }

    public static function decryptText($encryptedText): String
    {
        return openssl_decrypt($encryptedText, self::$method, self::$key, self::$options, self::$iv);
    }
}
