<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Order;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
            // ->each(function ($order)
            // {  
            //     $product_id=array_slice(shuffle($product_ids),0,1);
            //     Order_item::factory()->count(rand(1,3))->create(
            //     ['order_id'=> $order->id,
            //     'product_id'=>$product_id]);
                
            //});
    }
}
