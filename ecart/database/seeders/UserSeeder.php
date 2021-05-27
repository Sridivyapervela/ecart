<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Database\Seeders\OrderSeeder,
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
            $this->call([
            OrderSeeder::class,
            ])->with( ['user_id'=> $user->id]);
        //     Order::factory()->count(rand(1,5))->create(
        //         ['user_id'=> $user->id])
        //     ->each(function ($order)
        //     {  
        //         Order_item::factory()->count(rand(1,3))->create(
        //         ['order_id'=> $order->id]);
                
        // });
    });


}
}
