<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use Illuminate\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Perangkat', 'description' => 'Kerusakan atau kendala perangkat keras seperti komputer, laptop, dan aksesori'],
            ['name' => 'Aplikasi', 'description' => 'Masalah instalasi, penggunaan, atau error pada aplikasi dan sistem'],
            ['name' => 'Akun & Akses', 'description' => 'Reset password, pembuatan akun, dan masalah hak akses'],
            ['name' => 'Jaringan', 'description' => 'Koneksi internet, WiFi, dan masalah jaringan'],
            ['name' => 'Lainnya', 'description' => 'Permintaan bantuan IT lainnya'],
        ];

        foreach ($categories as $category) {
            TicketCategory::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
