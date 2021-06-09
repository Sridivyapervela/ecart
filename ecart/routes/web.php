<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", [HomeController::class, "index"])->middleware(
  "user-login-check"
);

Auth::routes();

Route::resource("products", ProductController::class);
Route::resource("categories", CategoryController::class);

Route::middleware(["auth"])->group(function () {
  Route::resource("users", UserController::class);
  Route::resource("carts", CartController::class);
  Route::resource("orders", OrderController::class);
  Route::get("/ordernow", [CartController::class, "index"]);
  Route::post("/placeorder", [CartController::class, "placeOrder"]);
});

Route::group(["prefix" => "admin", "middleware" => "admin"], function () {
  Route::resource("users", App\Http\Controllers\Admin\UserController::class);
  Route::resource(
    "products",
    App\Http\Controllers\Admin\ProductController::class
  );
  Route::resource(
    "categories",
    App\Http\Controllers\Admin\CategoryController::class
  );
  Route::resource("orders", App\Http\Controllers\Admin\OrderController::class);
});
