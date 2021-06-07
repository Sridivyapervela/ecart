<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;

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

Route::post("/add_to_cart", [
  ProductController::class,
  "addToCart",
])->middleware("auth");
Route::get("/cartlist", [ProductController::class, "cartList"]);
Route::post("/ordernow", [ProductController::class, "orderNow"]);
Route::post("/placeorder", [ProductController::class, "placeOrder"]);
Route::get("/products/delete/{product_id}", [
  ProductController::class,
  "destroy",
]);
Route::get("/users/delete/{user_id}", [UserController::class, "destroy"]);
Route::get("/categories/delete/{category_id}", [
  CategoryController::class,
  "destroy",
]);

Route::put("/products/{product_id}/edit", [
  ProductController::class,
  "edit",
])->middleware("admin");
Route::resource("products", ProductController::class);
Route::middleware(["auth"])->group(function () {
  Route::resource("users", UserController::class);
  Route::resource("categories", CategoryController::class);
  Route::resource("orders", OrderController::class);
});
