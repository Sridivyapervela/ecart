<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $cart = Cart::firstOrCreate([
      "user_id" => Auth::id(),
      "product_id" => $request->product_id,
      "quantity" => $request->quantity,
    ]);
    return redirect("/");
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
  public static function cartItem()
  {
    $userId = Auth::id();
    return Cart::where("user_id", $userId)->count();
  }
  public function orderNow(Request $request)
  {
    $userId = Auth::id();
    $products = DB::table("carts")
      ->join("products", "carts.product_id", "=", "products.id")
      ->where("carts.user_id", $userId)
      ->get();
    $total = 0;
    $price_list = [];
    foreach ($products as $product) {
      $price_per_unit = $product->price;
      $quantity = $product->quantity;
      $price = $price_per_unit * $quantity;
      array_push($price_list, $price);
      $total = $total + $price;
    }
    return view("/carts/ordernow", [
      "products" => $products,
      "total" => $total,
      "product_prices" => $price_list,
    ]);
  }
  public function placeOrder(Request $request)
  {
    $order = new Order([
      "user_id" => Auth::id(),
      "amount" => $request->total,
      "status" => "pending",
      "ordered_at" => Carbon::now(),
    ]);
    $order->save();
    $userId = Auth::id();
    $products = DB::table("carts")
      ->join("products", "carts.product_id", "=", "products.id")
      ->where("carts.user_id", $userId)
      ->get();
    $count = -1;
    foreach ($products as $product) {
      $orderItem = new OrderItem([
        "order_id" => Order::orderby("id", "desc")->first()->id,
        "product_id" => $product->id,
        "price" => $product->price,
        "quantity" => $product->quantity,
        "ordered_at" => Carbon::now(),
      ]);
      $orderItem->save();
    }
    $cart = Cart::where("user_id", Auth::id());
    $cart->delete();
    $this->sendMail();
    return redirect("products")->with(["msg" => "Order placed succesfully"]);
  }
  public function sendMail()
  {
    \Mail::send(
      "carts\mail",
      [
        "name" => Auth::user()->name,
        "email" => Auth::user()->email,
        "subject" => "Order Confirmation",
        "form_message" => "This is to inform you that your order is confirmed",
      ],
      function ($message) {
        $message->from("sridivyapervela357@gmail.com");
        $message
          ->to(Auth::user()->email, "Dear customer")
          ->subject("Order Confirmation");
      }
    );
  }
}
