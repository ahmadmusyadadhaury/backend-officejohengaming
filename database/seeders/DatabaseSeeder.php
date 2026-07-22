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
        // Teams (game-based)
        $teams = [
            ['name' => 'Tim Konten',         'description' => 'Tim yang mengelola konten'],
            ['name' => 'Johen Roblox',       'description' => 'Tim game Johen Roblox'],
            ['name' => 'Johen PUBG',         'description' => 'Tim game Johen PUBG'],
            ['name' => 'Johen MLBB',         'description' => 'Tim game Johen MLBB'],
            ['name' => 'Johen Free Fire',    'description' => 'Tim game Johen Free Fire'],
            ['name' => 'Johen E-Football',   'description' => 'Tim game Johen E-Football'],
            ['name' => 'Kreatif',            'description' => 'Tim kreatif'],
            ['name' => 'IT',                 'description' => 'Tim IT'],
            ['name' => 'Tim Marketing',      'description' => 'Tim yang mengelola pemasaran'],
            ['name' => 'Tim Operasional',    'description' => 'Tim yang mengelola operasional'],
        ];
        foreach ($teams as $team) {
            Team::create($team);
        }

        // Admin & Full Access
        User::create(['name' => 'Admin Master',              'username' => 'admin',     'email' => 'admin@johen.com',     'password' => Hash::make('password'), 'role' => 'admin']);
        User::create(['name' => 'Head of Store',             'username' => 'headstore', 'email' => 'headstore@johen.com', 'password' => Hash::make('password'), 'role' => 'head_of_store']);
        User::create(['name' => 'General Manager',           'username' => 'gm',        'email' => 'gm@johen.com',        'password' => Hash::make('password'), 'role' => 'gm']);
        User::create(['name' => 'HR Manager',                'username' => 'hr',        'email' => 'hr@johen.com',        'password' => Hash::make('password'), 'role' => 'hr']);
        User::create(['name' => 'Chief Executive Officer',   'username' => 'ceo',       'email' => 'ceo@johen.com',       'password' => Hash::make('password'), 'role' => 'ceo']);
        User::create(['name' => 'Admin General Affairs',     'username' => 'admin_ga',  'email' => 'admin_ga@johen.com',  'password' => Hash::make('password'), 'role' => 'admin_ga']);

        // Koordinator — masing-masing terikat ke team game-nya
        User::create(['name' => 'Koordinator Konten',       'username' => 'koordinator1',  'email' => 'koordinator1@johen.com',  'password' => Hash::make('password'), 'role' => 'koordinator', 'team_id' => 1]);
        User::create(['name' => 'Koordinator Roblox',       'username' => 'Johen.roblox',  'email' => 'johen.roblox@johen.com',  'password' => Hash::make('password'), 'role' => 'koordinator', 'team_id' => 2]);
        User::create(['name' => 'Koordinator PUBG',         'username' => 'Johen.PUBG',    'email' => 'johen.pubg@johen.com',    'password' => Hash::make('password'), 'role' => 'koordinator', 'team_id' => 3]);
        User::create(['name' => 'Koordinator MLBB',         'username' => 'Johen.MLBB',    'email' => 'johen.mlbb@johen.com',    'password' => Hash::make('password'), 'role' => 'koordinator', 'team_id' => 4]);
        User::create(['name' => 'Koordinator Free Fire',    'username' => 'Johen.FreeFire','email' => 'johen.freefire@johen.com','password' => Hash::make('password'), 'role' => 'koordinator', 'team_id' => 5]);
        User::create(['name' => 'Koordinator E-Football',   'username' => 'Johen.EFootbal','email' => 'johen.efootbal@johen.com','password' => Hash::make('password'), 'role' => 'koordinator', 'team_id' => 6]);
        User::create(['name' => 'Koordinator Kreatif',      'username' => 'creatif',       'email' => 'creatif@johen.com',       'password' => Hash::make('password'), 'role' => 'koordinator', 'team_id' => 7]);
        User::create(['name' => 'Koordinator IT',           'username' => 'it',            'email' => 'it@johen.com',            'password' => Hash::make('password'), 'role' => 'koordinator', 'team_id' => 8]);

        // User biasa
        User::create(['name' => 'Karyawan Konten', 'username' => 'user1', 'email' => 'user1@johen.com', 'password' => Hash::make('password'), 'role' => 'user', 'team_id' => 1]);

        // Rooms — masing-masing khusus per game
        Room::create(['name' => 'Meeting Room Utama', 'capacity' => 50, 'facilities' => ['Proyektor', 'TV', 'Speaker', 'Whiteboard', 'AC'], 'location' => 'Lantai 1', 'description' => 'Ruang meeting utama — bisa dipakai semua divisi', 'is_active' => true]);
        Room::create(['name' => 'Ruang Konten',      'capacity' => 15, 'facilities' => ['TV', 'Whiteboard'], 'location' => 'Lantai 1', 'description' => 'Khusus Tim Konten', 'is_active' => true, 'team_id' => 1]);
        Room::create(['name' => 'Ruang Roblox',      'capacity' => 10, 'facilities' => ['TV', 'AC'], 'location' => 'Lantai 2', 'description' => 'Khusus Johen Roblox', 'is_active' => true, 'team_id' => 2]);
        Room::create(['name' => 'Ruang PUBG',        'capacity' => 10, 'facilities' => ['TV', 'AC'], 'location' => 'Lantai 2', 'description' => 'Khusus Johen PUBG', 'is_active' => true, 'team_id' => 3]);
        Room::create(['name' => 'Ruang MLBB',        'capacity' => 10, 'facilities' => ['TV', 'AC'], 'location' => 'Lantai 2', 'description' => 'Khusus Johen MLBB', 'is_active' => true, 'team_id' => 4]);
        Room::create(['name' => 'Ruang Free Fire',   'capacity' => 10, 'facilities' => ['TV', 'AC'], 'location' => 'Lantai 2', 'description' => 'Khusus Johen Free Fire', 'is_active' => true, 'team_id' => 5]);
        Room::create(['name' => 'Ruang E-Football',  'capacity' => 10, 'facilities' => ['TV', 'AC'], 'location' => 'Lantai 2', 'description' => 'Khusus Johen E-Football', 'is_active' => true, 'team_id' => 6]);
        Room::create(['name' => 'Ruang Kreatif',     'capacity' => 15, 'facilities' => ['TV', 'Whiteboard'], 'location' => 'Lantai 3', 'description' => 'Khusus tim kreatif', 'is_active' => true, 'team_id' => 7]);
        Room::create(['name' => 'Ruang IT',          'capacity' => 10, 'facilities' => ['TV', 'AC'], 'location' => 'Lantai 3', 'description' => 'Khusus tim IT', 'is_active' => true, 'team_id' => 8]);

        // Assets
        foreach (['TV', 'Speaker', 'Proyektor', 'Whiteboard', 'Laptop', 'Kamera'] as $asset) {
            Asset::create(['name' => $asset, 'quantity' => 2, 'is_active' => true]);
        }

        $this->call(WeeklyMeetingSeeder::class);
        $this->call(TeamCompositionSeeder::class);
    }
}
