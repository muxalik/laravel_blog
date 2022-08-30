<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        ]];

        foreach ($users as $user) 
        {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt($user['password']),
                'is_admin' => isset($user['is_admin']) 
                    ? $user['is_admin'] 
                    : 0 
            ]);
        }

        User::factory(117)->create();
    }
}
