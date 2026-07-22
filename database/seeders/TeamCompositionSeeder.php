<?php

namespace Database\Seeders;

use App\Models\TeamComposition;
use Illuminate\Database\Seeder;

class TeamCompositionSeeder extends Seeder
{
    public function run(): void
    {
        $compositions = [
            ['role' => 'ceo',           'label' => 'CEO',            'max_count' => 1,  'sort_order' => 1],
            ['role' => 'gm',            'label' => 'General Manager', 'max_count' => 1,  'sort_order' => 2],
            ['role' => 'head_of_store', 'label' => 'Head of Store',  'max_count' => 1,  'sort_order' => 3],
            ['role' => 'hr',            'label' => 'HR',             'max_count' => 7,  'sort_order' => 4],
            ['role' => 'koordinator',   'label' => 'Koordinator',    'max_count' => 5,  'sort_order' => 5],
            ['role' => 'total_team',    'label' => 'Total Tim',      'max_count' => 2,  'sort_order' => 6],
            ['role' => 'karyawan',      'label' => 'Karyawan',       'max_count' => 50, 'sort_order' => 7],
        ];

        foreach ($compositions as $comp) {
            TeamComposition::create($comp);
        }
    }
}
