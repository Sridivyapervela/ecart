<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
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
}
