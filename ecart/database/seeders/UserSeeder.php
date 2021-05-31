<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use Database\Seeders\OrderSeeder;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create()->each(function ($user)
        {
            Order::factory(count(rand(1,5)))->create(
                ['user_id'=> $user->id,
                ]);
    });


}
}
