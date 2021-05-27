<?php

namespace Database\Seeders;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->count(20)->create()
        ->each(function ($category)
        	{
        		Product::factory()->count(rand(1,7))->create(
        			['category_id'=> $category->id]);
        		
        	});
    }
}
