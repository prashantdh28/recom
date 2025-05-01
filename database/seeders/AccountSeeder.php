<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $msgs = [];
        foreach (range(1, 100) as $index) { // Generate 50 fake messages
            $msgs[] = [
                'name' => fake()->name(), // Assuming 10 users exist
                'client_id' => fake()->uuid(),
                'client_secret' => fake()->sentence(),
                'api_status' => rand(1,2),
                'status' => array_rand([0,1], 1),
                'token_updated' => fake()->dateTime(),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        Account::insert($msgs);
    }
}
