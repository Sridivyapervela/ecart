<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Database\Seeders\UserSeeder,
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
        $products=Product::all();
        $product_ids=$products->id;
        Order::factory()->count(rand(1,5))->create(
                ['user_id'=> $user->id,
                'product_ids'=>$product_ids]);
            // ->each(function ($order)
            // {  
            //     $product_id=array_slice(shuffle($product_ids),0,1);
            //     Order_item::factory()->count(rand(1,3))->create(
            //     ['order_id'=> $order->id,
            //     'product_id'=>$product_id]);
                
            //});
    }
}
