<?php

namespace App\Helpers;

use App\Exceptions\CustomException;
use Exception;
use Random\RandomException;

class EncryptionHelper
{
    protected static function getKey(): string
    {
        return config('encryption.key');
    }

    /**
     * @throws RandomException
     * @throws Exception
     */
    public static function secureString(mixed $input, string $action = 'encrypt'): string|array
    {
        $cipher = 'AES-256-CBC';
        $key = static::getKey();

        if ($action === 'encrypt') {
            if (!is_string($input)) {
                $input = json_encode($input, JSON_THROW_ON_ERROR);
            }
            $iv = random_bytes(openssl_cipher_iv_length($cipher));
            $encrypted = openssl_encrypt($input, $cipher, $key, 0, $iv);
            return base64_encode($iv . $encrypted);
        }

        if ($action === 'decrypt') {
            $decoded = base64_decode($input);
            $ivLength = openssl_cipher_iv_length($cipher);
            if ($decoded === false || strlen($decoded) <= $ivLength) {
                throw new CustomException('Invalid or malformed token.');
            }
            $iv = substr($decoded, 0, $ivLength);
            $cipherText = substr($decoded, $ivLength);
            $decryptedData = openssl_decrypt($cipherText, $cipher, $key, 0, $iv);

            $decoded = json_decode($decryptedData, true);
            return json_last_error() === JSON_ERROR_NONE ? $decoded : $decryptedData;
        }
        throw new CustomException('Invalid action. Use "encrypt" or "decrypt".');
    }
}
