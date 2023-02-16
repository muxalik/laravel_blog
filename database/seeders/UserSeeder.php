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
            'password' => 'password',
            'is_admin' => 1,
        ];

        $user = [
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => 'password',
            'is_admin' => 0
        ];

        User::create($admin);
        User::create($user);

        User::factory(env('USERS_AMOUNT', 100))->create();
    }
}
