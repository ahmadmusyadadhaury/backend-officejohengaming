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
            ['name' => 'Tim Konten',      'description' => 'Tim yang mengelola konten'],
            ['name' => 'Tim Host Live',   'description' => 'Tim yang mengelola live streaming'],
            ['name' => 'Tim Marketing',   'description' => 'Tim yang mengelola pemasaran'],
            ['name' => 'Tim Operasional', 'description' => 'Tim yang mengelola operasional'],
        ];
        foreach ($teams as $team) {
            Team::create($team);
        }

        // Admin Master
        User::create(['name' => 'Admin Master',    'username' => 'admin',    'email' => 'admin@johen.com',    'password' => Hash::make('password'), 'role' => 'admin']);
        // Head of Store
        User::create(['name' => 'Head of Store',   'username' => 'headstore', 'email' => 'headstore@johen.com', 'password' => Hash::make('password'), 'role' => 'head_of_store']);
        // GM
        User::create(['name' => 'General Manager', 'username' => 'gm',       'email' => 'gm@johen.com',       'password' => Hash::make('password'), 'role' => 'gm']);
        // HR
        User::create(['name' => 'HR Manager',      'username' => 'hr',       'email' => 'hr@johen.com',       'password' => Hash::make('password'), 'role' => 'hr']);
        // CEO
        User::create(['name' => 'Chief Executive Officer', 'username' => 'ceo', 'email' => 'ceo@johen.com', 'password' => Hash::make('password'), 'role' => 'ceo']);
        // Admin General Affairs
        User::create(['name' => 'Admin General Affairs', 'username' => 'admin_ga', 'email' => 'admin_ga@johen.com', 'password' => Hash::make('password'), 'role' => 'admin_ga']);
        // Koordinator
        User::create(['name' => 'Koordinator Konten', 'username' => 'koordinator1', 'email' => 'koordinator1@johen.com', 'password' => Hash::make('password'), 'role' => 'koordinator', 'team_id' => 1]);
        // User
        User::create(['name' => 'Karyawan Konten',    'username' => 'user1', 'email' => 'user1@johen.com', 'password' => Hash::make('password'), 'role' => 'user', 'team_id' => 1]);

        // Room
        Room::create([
            'name' => 'Meeting Room Utama',
            'capacity' => 50,
            'facilities' => ['Proyektor', 'TV', 'Speaker', 'Whiteboard', 'AC'],
            'location' => 'Lantai 1',
            'description' => 'Ruang meeting utama Johen Gaming',
            'is_active' => true,
        ]);

        // Assets
        foreach (['TV', 'Speaker', 'Proyektor', 'Whiteboard', 'Laptop', 'Kamera'] as $asset) {
            Asset::create(['name' => $asset, 'quantity' => 2, 'is_active' => true]);
        }

        $this->call(WeeklyMeetingSeeder::class);
    }
}
