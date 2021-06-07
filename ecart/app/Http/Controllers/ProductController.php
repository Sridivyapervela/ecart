<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
  public function __construct()
  {
    $this->middleware("auth")->except(["show", "index"]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $products = Product::orderBy("created_at", "DESC")->paginate(50);
    return view("/products/index")->with(["products" => $products]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view("/products/create");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $category_ids = Category::where("id", ">", 0)
      ->pluck("id")
      ->toArray();
    $request->validate([
      "name" => "required",
      "code" => "required",
      "price" => "required",
      "status" => ["required", Rule::in(["active", "inactive"])],
      "available_stock" => "required",
      "category_id" => ["required", Rule::in($category_ids)],
      "image" => "mimes:jpeg,jpg,bmp,png,gif",
    ]);
    $product = new product([
      "name" => $request["name"],
      "code" => $request->code,
      "price" => $request->price,
      "status" => $request->status,
      "available_stock" => $request->available_stock,
      "category_id" => $request->category_id,
    ]);
    $product->save();
    if ($request->image) {
      $this->saveImages($request->image, $product->id);
    }
    return $this->index()->with([
      "mes_suc" => "product " . $product->name . " is added succesfully",
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function show(Product $product)
  {
    if ($product->status == "active") {
      return view("/products/show")->with(["product" => $product]);
    } else {
      return view("/products");
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function edit(Product $product)
  {
    return view("/products/edit")->with(["product" => $product]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Product $product)
  {
    $category_ids = Category::where("id", ">", 0)
      ->pluck("id")
      ->toArray();
    $request->validate([
      "name" => "required",
      "code" => "required",
      "price" => "required",
      "status" => ["required", Rule::in(["active", "inactive"])],
      "available_stock" => "required",
      "category_id" => ["required", Rule::in($category_ids)],
      "image" => "mimes:jpeg,jpg,bmp,png,gif",
    ]);
    $product->update([
      "name" => $request["name"],
      "code" => $request->code,
      "price" => $request->price,
      "status" => $request->status,
      "available_stock" => $request->available_stock,
      "category_id" => $request->category_id,
    ]);
    if ($request->image) {
      $this->saveImages($request->image, $product->id);
    }
    return redirect("/products")->with([
      "mes_suc" => "Succesfully updated!",
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function destroy(Product $product)
  {
    abort_unless(auth()->user()->role = "admin", 403);
    $old = $product->name;
    $product->forceDelete();
    return redirect("products")->with([
      "mes_suc" => "product " . $old . " is deleted succesfully",
    ]);
  }
  public function saveImages($imageInput, $product_id)
  {
    $image = Image::make($imageInput);
    if ($image->width() > $image->height()) {
      // Landscape
      $image
        ->widen(500)
        ->save(public_path() . "/img/products/" . $product_id . "_large.jpg");
      $image = Image::make($imageInput);
      $image
        ->widen(120)
        ->save(public_path() . "/img/products/" . $product_id . "_thumb.jpg");
    } else {
      // Portrait
      $image
        ->heighten(500)
        ->save(public_path() . "/img/products/" . $product_id . "_large.jpg");
      $image = Image::make($imageInput);
      $image
        ->heighten(120)
        ->save(public_path() . "/img/products/" . $product_id . "_thumb.jpg");
    }
  }
  public function addToCart(Request $request)
  {
    $cart = Cart::firstOrCreate([
      "user_id" => Auth::id(),
      "product_id" => $request->product_id,
    ]);
    return view("/products/cartlist");
  }
  public static function cartItem()
  {
    $userId = Auth::id();
    return Cart::where("user_id", $userId)->count();
  }
  public static function cartList()
  {
    return view("/products/cartlist");
  }
  public function orderNow(Request $request)
  {
    $userId = Auth::id();
    $products = DB::table("carts")
      ->join("products", "carts.product_id", "=", "products.id")
      ->where("carts.user_id", $userId)
      ->select("products.*")
      ->get();
    $total = 0;
    $quantity_list = [];
    $price_of_product = [];
    foreach ($request->product as $product) {
      $price_per_unit = array_keys($product)[0];
      $quantity = $product[$price_per_unit];
      $price = $price_per_unit * $quantity;
      $total = $total + $price;
      array_push($quantity_list, $quantity);
      array_push($price_of_product, $price);
    }
    return view("/products/ordernow", [
      "products" => $products,
      "total" => $total,
      "product_prices" => $price_of_product,
      "quantities" => $quantity_list,
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
      ->select("products.*")
      ->get();
    $count = -1;
    foreach ($products as $product) {
      $count = $count + 1;
      $orderItem = new OrderItem([
        "order_id" => Order::orderby("id", "desc")->first()->id,
        "product_id" => $product->id,
        "price" => $product->price,
        "quantity" => $request->quantity[$count],
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
      "products\mail",
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
