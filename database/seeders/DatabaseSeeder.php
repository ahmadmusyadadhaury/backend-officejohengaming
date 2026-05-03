<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Room;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Teams
        $teams = [
            ['name' => 'Tim Konten', 'description' => 'Tim yang mengelola konten'],
            ['name' => 'Tim Host Live', 'description' => 'Tim yang mengelola live streaming'],
            ['name' => 'Tim Marketing', 'description' => 'Tim yang mengelola pemasaran'],
            ['name' => 'Tim Operasional', 'description' => 'Tim yang mengelola operasional'],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }

        // Admin HR
        User::create([
            'nik'       => 'JG-ADMIN-001',
            'name'      => 'Admin HR',
            'email'     => 'admin@johengaming.com',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // Admin GM
        User::create([
            'nik'       => 'JG-ADMIN-002',
            'name'      => 'Admin GM',
            'email'     => 'gm@johengaming.com',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // Leader Tim Konten
        User::create([
            'nik'       => 'JG-001',
            'name'      => 'Kepala Tim Konten',
            'email'     => 'leader.konten@johengaming.com',
            'password'  => Hash::make('password'),
            'role'      => 'leader',
            'team_id'   => 1,
            'is_leader' => true,
            'is_active' => true,
        ]);

        // User Tim Konten
        User::create([
            'nik'       => 'JG-002',
            'name'      => 'Karyawan Konten 1',
            'email'     => 'user1@johengaming.com',
            'password'  => Hash::make('password'),
            'role'      => 'user',
            'team_id'   => 1,
            'is_active' => true,
        ]);

        // Room
        Room::create([
            'name'        => 'Meeting Room Utama',
            'capacity'    => 50,
            'facilities'  => ['Proyektor', 'TV', 'Speaker', 'Whiteboard', 'AC'],
            'location'    => 'Lantai 1',
            'description' => 'Ruang meeting utama Johen Gaming',
            'is_active'   => true,
        ]);

        // Assets
        $assets = ['TV', 'Speaker', 'Proyektor', 'Whiteboard', 'Laptop', 'Kamera'];
        foreach ($assets as $asset) {
            Asset::create(['name' => $asset, 'quantity' => 2, 'is_active' => true]);
        }
    }
}
