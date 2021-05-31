<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'price'=>$this->faker->numberBetween(100,25000),
            'quantity'=>$this->faker->numberBetween(1,10),
        ];
    }
}
