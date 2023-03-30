<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
            'is_admin' => 1,
        ];

        $user = [
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => bcrypt('password'),
            'is_admin' => 0
        ];

        User::insert([$admin, $user]);

        $data = [];

        for ($i = 0; $i < env('USERS_AMOUNT', 100); $i++) {
            $registry = fake()->optional(0.3, fake()->unique()->dateTimeThisYear())->dateTimeBetween('-2 year');
            
            $data[] = [
                'name' => fake()->name(),
                'email' => fake()->unique()->freeEmail(),
                'password' => fake()->password(),
                'is_admin' => fake()->optional(0.9, 1)->randomElement([0]),
                'created_at' => $registry,
                'updated_at' => fake()->dateTimeBetween($registry),
            ];
        }

        foreach (array_chunk($data, 100) as $chunk) {
            User::insert($chunk);
        }
    }
}
