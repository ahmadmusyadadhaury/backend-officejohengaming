<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use Illuminate\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Hardware', 'description' => 'Komputer, laptop, mouse, keyboard, dan perangkat keras lainnya'],
            ['name' => 'Software', 'description' => 'Aplikasi, sistem operasi, dan instalasi program'],
            ['name' => 'Jaringan & Internet', 'description' => 'Koneksi internet, WiFi, dan masalah jaringan'],
            ['name' => 'Printer & Scanner', 'description' => 'Masalah printer, scanner, dan perangkat cetak'],
            ['name' => 'Email & Akun', 'description' => 'Reset password, pembuatan akun, dan masalah email'],
            ['name' => 'Meeting Room & Multimedia', 'description' => 'Proyektor, TV, speaker, dan perangkat meeting'],
            ['name' => 'Lainnya', 'description' => 'Permintaan bantuan IT lainnya'],
        ];

        foreach ($categories as $category) {
            TicketCategory::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
