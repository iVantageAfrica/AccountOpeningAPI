<?php

if (!function_exists('generateRandomAlphabet')) {
    function generateRandomAlphabet(int $length = 15): string
    {
        $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($string), 0, $length);
    }
}


if (!function_exists('generateDateId')) {
    function generateDateId(): string
    {
        return date('YmdHis');
    }
}



if (!function_exists('generateRandomNumber')) {
    function generateRandomNumber(int $length = 10): string
    {
        $string = '0123456789';
        return substr(str_shuffle($string), 0, $length);
    }
}

if (!function_exists('generateRandomAlphanumeric')) {
    function generateRandomAlphanumeric(int $length = 10): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($characters), 0, $length);
    }
}

if (!function_exists('generateId')) {
    function generateId(?string $firstValue = null, ?string $lastValue = null, int $length = 10): string
    {
        if ($firstValue && $lastValue) {
            $prefix = $firstValue[0] . $lastValue[0];
        } elseif ($firstValue) {
            $prefix = substr($firstValue, 0, 2);
        } else {
            $prefix = generateRandomAlphabet(2);
        }
        return strtoupper($prefix) . generateRandomNumber(5);
    }
}

if (!function_exists('extractGenericId')) {
    function extractGenericId(?string $value = null, int $length = 10): string
    {
        if (!$value) {
            return generateRandomAlphabet($length);
        }

        return strtoupper(substr($value, 0, $length));
    }
}

if (!function_exists('generateCustomId')) {
    /**
     * Generate a custom ID using part of a string and random numbers.
     *
     * @param string $input The input string.
     * @param int $stringLength The number of characters to take from the input string.
     * @return string The generated custom ID.
     */
    function generateCustomId(string $input, int $stringLength): string
    {
        $prefix = substr(str_replace([' ', '-', "'", '.'], '', $input), 0, $stringLength);
        return strtoupper($prefix) . date('y-mdH-is');
    }
}
