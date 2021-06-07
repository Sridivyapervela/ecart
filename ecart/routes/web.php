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

Route::get("/ordernow", [CartController::class, "orderNow"]);
Route::post("/placeorder", [CartController::class, "placeOrder"]);

Route::get("/products/delete/{product_id}", [
  ProductController::class,
  "destroy",
]);
Route::get("/users/delete/{user_id}", [UserController::class, "destroy"]);
Route::get("/categories/delete/{category_id}", [
  CategoryController::class,
  "destroy",
]);

Route::resource("products", ProductController::class);
Route::resource("carts", CartController::class);
Route::middleware(["auth"])->group(function () {
  Route::resource("users", UserController::class);
  Route::resource("categories", CategoryController::class);
  Route::resource("orders", OrderController::class);
});
