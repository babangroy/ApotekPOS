<?php

namespace App\Support;

class MoneyHelper
{
    public static function parse($value): float
    {
        if ($value === null || $value === '') {
            return 0.0;
        }

        $s = (string) $value;

        $clean = str_replace(',', '', $s);

        return floatval($clean) ?: 0.0;
    }

public static function format($value, int $decimals = 0): string
{
    $number = (float) $value;
    
    // Untuk currency, biasanya mau tetap ada pemisah ribuan meski angka bulat
    return number_format($number, $decimals, ',', '.');
}
}
