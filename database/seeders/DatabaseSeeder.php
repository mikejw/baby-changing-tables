<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeded users are intentionally created with unknown random
        // passwords. Log in via the master password (AUTH_MASTER_PASSWORD).
        $unknownPassword = fn (): string => Hash::make(Str::random(40));

        User::factory()->create([
            'name' => 'Mike',
            'email' => 'mike@ai-em.net',
            'password' => $unknownPassword(),
        ]);

        User::factory()->create([
            'name' => 'June',
            'email' => 'junewhiting@gmail.com',
            'password' => $unknownPassword(),
        ]);

        User::factory()->create([
            'name' => 'Elainne',
            'email' => 'elajoe12345@gmail.com',
            'password' => $unknownPassword(),
        ]);

        // Demo feed data is intentionally not seeded by default. To populate
        // the feeds table with example data run:
        //
        //   sail artisan db:seed --class=FeedSeeder
    }
}
