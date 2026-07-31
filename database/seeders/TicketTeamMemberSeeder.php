<?php

namespace Database\Seeders;

use App\Models\TicketTeamMember;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketTeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $itUsers = User::where('username', 'it')->orWhere('email', 'it@johen.com')->get();

        foreach ($itUsers as $user) {
            TicketTeamMember::firstOrCreate(
                ['user_id' => $user->id],
                ['is_leader' => true]
            );
        }

        $admin = User::where('username', 'admin')->first();
        if ($admin) {
            TicketTeamMember::firstOrCreate(
                ['user_id' => $admin->id],
                ['is_leader' => true]
            );
        }
    }
}
