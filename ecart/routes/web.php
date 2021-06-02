<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

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

Route::get('/', function () {
    if(auth()->user()){
        return redirect('home');
    }
    else{
        return view('\auth\login');
    }
});

Route::resource("user",UserController::class);
Route::resource("category",CategoryController::class);
Route::resource("product",ProductController::class);
Route::resource("order",OrderController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/product', [ProductController::class,'store']);
Route::post('/category', [CategoryController::class,'store']);
Route::post('/add_to_cart', [ProductController::class,'addToCart']);
Route::get('/cartlist', [ProductController::class,'cartList']);
Route::post('/ordernow', [ProductController::class,'orderNow']);
Route::post('/placeorder', [ProductController::class,'placeOrder']);
Route::get('/product/delete/{id}',[ProductController::class,'destroy']);
Route::get('/user/delete/{id}',[UserController::class,'destroy']);
Route::get('/category/delete/{id}',[CategoryController::class,'destroy']);

