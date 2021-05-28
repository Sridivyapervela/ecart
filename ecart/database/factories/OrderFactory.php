<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Order_item;
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
        Order_item::factory()->count(rand(1,3))->create(
            ['order_id'=>$order_id,
            'product_id'=>$product_id])
            ->each(function($order_item){
                DB::table('order_item_product')
                ->insert(
                [
                'order_item_id' => $order_item->id,
                'product_id' => $product_id,
                'created_at' => Now(),
                'updated_at' => Now()
                ]);
            });
        $order_items=Order_item::where('order_id','=','$order_id');
        $amount=0;
        foreach($order_items as $order_item)
        {
            $amount=$amount+($order_item->price*$order_item->quantity);
        }
        return [
            'amount' => $amount,
            'status' => $this->faker->randomElement($array=array('pending','success','failed')),
            'ordered_at' => Carbon::now(),
        ];
    }
}
