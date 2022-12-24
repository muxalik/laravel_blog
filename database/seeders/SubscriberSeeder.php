<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscribers = Subscriber::factory(env('SUBSCRIBERS_AMOUNT', 40))
            ->create()->random(ceil(env('SUBSCRIBERS_AMOUNT', 40) / 2));

        $users = User::inRandomOrder()->limit(ceil(env('USERS_AMOUNT', 100) / 4))->get();

        $subscribers->each(function ($subscriber, $key) use ($users) {
            $user = $users[$key];
            $subscriber->update(['user_id' => $user->id]);
            $user->update(['subscriber_id' => $subscriber->id]);
        });
    }
}
