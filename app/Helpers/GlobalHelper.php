<?php

if (!function_exists('arabic_number')) {
    /**
     * Mengkonversi angka Western (0-9) ke angka Arab Timur (٠-٩).
     *
     * @param int|string $number
     * @return string
     */
    function arabic_number($number)
    {
        // Pastikan input berupa string untuk diproses
        $number = (string) $number;
        
        $western = ['0','1','2','3','4','5','6','7','8','9'];
        $eastern = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        
        return str_replace($western, $eastern, $number);
    }
}