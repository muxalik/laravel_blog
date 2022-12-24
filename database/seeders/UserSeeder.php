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
        $users = [[
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => 'admin',
            'is_admin' => 1,
        ], [
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => 'user',
            'is_admin' => 0
        ]];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
                'is_admin' => $user['is_admin']
            ]);
        }

        $users = User::factory(env('USERS_AMOUNT', 100))->create();
    }
}
