<?php

namespace App\Validation;

class CustomRules
{
    /**
     * Validasi umur minimal
     * 
     * @param string $value
     * @param string $params
     * @param array $data
     * @return bool
     */
    public function check_min_age(string $value, string $params, array $data): bool
    {
        // Ambil tanggal lahir dari input
        $birthDate = new \DateTime($value);
        $today = new \DateTime('today');

        // Hitung umur
        $age = $birthDate->diff($today)->y;

        // Cek apakah umur minimal 17 tahun
        return $age >= 17;
    }
}
