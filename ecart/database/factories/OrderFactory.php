 <?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Order_item;
use Illuminate\Database\Eloquent\Factories\Factory;
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
        $product_id=array_slice(shuffle($product_ids),0,1);
        Order_item::factory()->count(rand(1,3))->create(
            ['order_id'=> $order->id,
            'product_id'=>$product_id]);
        $order_items=Order_item::where('order_id','=','$order->id');
        $amount=0;
        foreach($order_items as $order_item)
        {
            $amount=$amount+($order_item->price*$order_item->quantity);
        }
        return [
            'user_id'=> $user->id,
            'amount' => $amount,
            'status' => $this->faker->randomElement($array=array('pending','success','failed')),
            'ordered_at' => Carbon::now(),
        ];
    }
}
