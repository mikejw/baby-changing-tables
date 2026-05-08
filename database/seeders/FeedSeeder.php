<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Feed;


class FeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Feed::create([
            'nappy_wet' => true,
            'nappy_poo' => false,
            'breast_fed' => true,
            'formula_ounces' => 2.50,
            'skin_to_skin_minutes' => 45,
            'cry_level' => 2,
            'temperature' => 36.70,
            'change_of_clothes' => false,
            'table_wee' => false,
            'table_poo' => false,
            'time_in_sun' => 10,
            'notes' => 'Fed well and settled quickly afterwards.',
        ]);
    }
}
