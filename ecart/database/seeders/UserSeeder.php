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
            Order::factory()->count(rand(1,5))->create(
                ['user_id'=> $user->id,
                ])
                ->each(function ($order){
                    $product_id=Product::inRandomOrder()->first()->id;
                    OrderItem::factory()->count(rand(1,3))->create(
                    ['order_id'=>$order->id,
                    'product_id'=>$product_id]);
                    $orderId=$order->id;
                    $amount=DB::table('order_items')
                    ->select(DB::raw('sum(order_items.price * order_items.quantity) as total'))
                    ->where('order_items.order_id',$orderId)
                    ->first();
                    DB::table('orders')
                    ->update(['amount'=>$amount->total]);
                });  
        });
}
}
