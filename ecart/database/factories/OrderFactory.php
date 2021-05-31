<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product_id=Product::inRandomOrder()->first()->id;
        $order_id=Order::first()->id;
        OrderItem::factory(count(rand(1,3)))->create(
            ['order_id'=>$order_id,
            'product_id'=>$product_id])
            ->each(function($orderItem){
                DB::table('order_item_product')
                ->insert(
                [
                'orderItem_id' => $orderItem->id,
                'product_id' => $product_id,
                'created_at' => Now(),
                'updated_at' => Now()
                ]);
            });
        $orderItems=OrderItem::where('order_id','=','$order_id');
        $amount=0;
        foreach($orderItems as $orderItem)
        {
            $amount=$amount+($orderItem->price*$orderItem->quantity);
        }
        return [
            'amount' => $amount,
            'status' => $this->faker->randomElement($array=array('pending','success','failed')),
            'ordered_at' => Carbon::now(),
        ];
    }
}
