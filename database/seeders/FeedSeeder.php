<?php

namespace Database\Seeders;

use App\Models\Feed;
use App\Models\User;
use Illuminate\Database\Seeder;

class FeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mike = User::where('email', 'mike@ai-em.net')->firstOrFail();
        $june = User::where('email', 'junewhiting@gmail.com')->firstOrFail();
        $elainne = User::where('email', 'elajoe12345@gmail.com')->firstOrFail();

        Feed::create([
            'nappy_wet' => true,
            'nappy_poo' => false,
            'breast_fed' => true,
            'fed_by' => $june->id,
            'changed_by' => $mike->id,
            'created_by' => $mike->id,
            'skin_to_skin_with' => $elainne->id,
            'skin_to_skin_minutes' => 45,
            'formula_ounces' => 2.50,
            'cry_level' => 2,
            'temperature' => 36.70,
            'change_of_clothes' => true,
            'clothes_changed_by' => $elainne->id,
            'table_wee' => false,
            'table_poo' => false,
            'time_in_sun' => 10,
            'time_in_sun_with' => $mike->id,
            'notes' => 'Fed well and settled quickly afterwards.',
        ]);

        Feed::factory()->count(49)->create();
    }
}
