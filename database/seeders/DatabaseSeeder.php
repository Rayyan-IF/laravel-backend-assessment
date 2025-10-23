<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'active' => true,
            'role' => 'admin',
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        User::factory(2)->create(['role' => 'manager']);
        User::factory(5)->create(['role' => 'user']);

        $allUsers = User::all();
        
        foreach ($allUsers as $user) {
            Order::factory(rand(1, 5))->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
