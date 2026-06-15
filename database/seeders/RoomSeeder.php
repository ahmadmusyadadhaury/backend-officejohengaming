<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create([
            'name' => 'Conference Room A',
            'capacity' => 10,
            'facilities' => ['Projector', 'Whiteboard', 'Video Conference'],
            'location' => 'Floor 1, Building A',
            'description' => 'Large conference room with projector and whiteboard',
            'is_active' => true,
        ]);

        Room::create([
            'name' => 'Meeting Room B',
            'capacity' => 6,
            'facilities' => ['Whiteboard', 'Coffee Machine'],
            'location' => 'Floor 2, Building A',
            'description' => 'Small meeting room for team discussions',
            'is_active' => true,
        ]);

        Room::create([
            'name' => 'Board Room',
            'capacity' => 20,
            'facilities' => ['Projector', 'Video Conference', 'Sound System'],
            'location' => 'Floor 3, Building A',
            'description' => 'Executive board room with video conferencing',
            'is_active' => true,
        ]);

        Room::create([
            'name' => 'Training Room',
            'capacity' => 15,
            'facilities' => ['Projector', 'Computers', 'Whiteboard'],
            'location' => 'Floor 1, Building B',
            'description' => 'Training room with computers and presentation equipment',
            'is_active' => true,
        ]);
    }
}
