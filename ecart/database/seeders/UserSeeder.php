<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Database\Seeders\OrderSeeder;
use Illuminate\Support\Facades\DB;
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
            $currentOrder=Order::factory()->count(rand(1,5))->create(
                ['user_id'=> $user->id,
                ])
                ->each(function ($order){
                    $product_id=Product::inRandomOrder()->first()->id;
                    OrderItem::factory()->count(rand(1,3))->create(
                    ['order_id'=>$order->id,
                    'product_id'=>$product_id])
                    ->each(function($orderItem){
                        DB::table('order_item_product')
                        ->insert(
                        [
                        'orderItem_id' => $orderItem->id,
                        'product_id' => $orderItem->product_id,
                        'created_at' => Now(),
                        'updated_at' => Now()
                        ]);
                    });
                    $items=OrderItem::where('order_id',$order->id);
                    $product_of_price_quantity=$items->price*$items->quantity;
                    $amount=DB::table('order_items')
                    ->where('order_id','=','$order->id')
                    ->sum($product_of_price_quantity);
                    DB::table('orders')
                    ->update(['amount'=>$amount]);
                });  
        });
}
}
