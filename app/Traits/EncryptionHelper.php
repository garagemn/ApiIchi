<?php

namespace App\Traits;

class EncryptionHelper
{
    private static $algorithm = 'AES-256-CBC';
    
    public static function encrypt($data) 
    {
        $sharedKey = config('auth.encryption_sharedkey');
        if(!$sharedKey) {
            \Log::info('shared key not found in config file');
            throw new \Exception('Encryption shared key is missing');
        }
        // \Log::info($sharedKey);
        $iv = substr(hash('sha256', $sharedKey), 0, 16); // Generate IV
        $encryptedData = openssl_encrypt(json_encode($data), self::$algorithm, $sharedKey, 0, $iv);
        $resultdata = [
            'iv' => base64_encode($iv),
            'data' => $encryptedData
        ];
        return $resultdata;
    }

    public static function decrypt($encryptedData, $iv)
    {
        $sharedKey = config('auth.encryption_sharedkey');
        $iv = base64_decode($iv);
        $decryptedData = openssl_decrypt($encryptedData, self::$algorithm, $sharedKey, 0, $iv);
        return $decryptedData;
    }
}