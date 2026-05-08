<?php

namespace Database\Factories;

use App\Models\Feed;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Feed>
 */
class FeedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck('id');

        $nappyWet = fake()->boolean(60);
        $nappyPoo = fake()->boolean(40);
        $changeOfClothes = fake()->boolean(20);

        $skinToSkinMinutes = fake()->boolean(50) ? fake()->numberBetween(5, 90) : null;
        $timeInSun = fake()->boolean(60) ? fake()->numberBetween(5, 60) : null;
        $formulaOunces = fake()->boolean(60) ? fake()->randomFloat(2, 0.5, 5.0) : null;

        $hasTemperature = fake()->boolean(70);
        $hasNotes = fake()->boolean(50);

        $createdAt = fake()->dateTimeBetween('-30 days', 'now');

        return [
            'nappy_wet' => $nappyWet,
            'nappy_poo' => $nappyPoo,
            'breast_fed' => fake()->boolean(70),
            'changed_by' => ($nappyWet || $nappyPoo) ? $userIds->random() : null,
            'change_of_clothes' => $changeOfClothes,
            'clothes_changed_by' => $changeOfClothes ? $userIds->random() : null,
            'created_by' => $userIds->random(),
            'formula_ounces' => $formulaOunces,
            'fed_by' => $formulaOunces !== null ? $userIds->random() : null,
            'skin_to_skin_minutes' => $skinToSkinMinutes,
            'skin_to_skin_with' => $skinToSkinMinutes !== null ? $userIds->random() : null,
            'time_in_sun' => $timeInSun,
            'time_in_sun_with' => $timeInSun !== null ? $userIds->random() : null,
            'cry_level' => fake()->numberBetween(0, 10),
            'temperature' => $hasTemperature ? fake()->randomFloat(2, 36.0, 38.0) : null,
            'table_wee' => fake()->boolean(15),
            'table_poo' => fake()->boolean(10),
            'notes' => $hasNotes ? fake()->sentence() : null,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
