<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->ean8(),
            'price' => $this->faker->numberBetween(200,10000),
            'status' => $this->faker->randomElement($array=array('active','inactive')),
            'available_stock' => $this->faker->numberBetween(0,10000),
        ];
    }
}
