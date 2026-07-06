<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use App\Models\WeeklyMeeting;
use Illuminate\Database\Seeder;

class WeeklyMeetingSeeder extends Seeder
{
    public function run(): void
    {
        $room = Room::first();
        $admin = User::where('role', 'admin')->first();

        if (! $room || ! $admin) {
            return;
        }

        WeeklyMeeting::create([
            'room_id' => $room->id,
            'title' => 'Weekly Meeting',
            'day_of_week' => 1,
            'start_time' => '13:00:00',
            'end_time' => '15:00:00',
            'is_active' => true,
            'created_by' => $admin->id,
        ]);

        $this->command->info('Weekly Meeting (Senin 13:00-15:00) created.');
    }
}
