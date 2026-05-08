<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Mike',
            'email' => 'mike@ai-em.net',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'June',
            'email' => 'junewhiting@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Elainne',
            'email' => 'elajoe12345@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $this->call([
            FeedSeeder::class,
        ]);
    }
}
