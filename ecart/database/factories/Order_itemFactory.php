<?php

namespace Database\Factories;

use App\Models\Order_item;
use Illuminate\Database\Eloquent\Factories\Factory;

class Order_itemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order_item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'order_id'=>$order_id,
            'price'=>$this->faker->numberBetween(100,25000),
            'quantity'=>$this->faker->numberBetween(1,10),
            'product_id'=>$product_id
        ];
    }
}
