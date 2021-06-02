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

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show','index']);
        $this->middleware('admin')->except(['show','index','addToCart','cartItem','cartList','orderNow','placeOrder']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $products=Product::orderBy('created_at','DESC')->paginate(50);
        return view('/product/index')->with(['products'=>$products]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/product/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name'=>'required',
            'code'=> 'required',
            'price'=> 'required',
            'status'=> 'required',
            'available_stock'=> 'required',
            'category_id'=>'required',
            'image' => 'mimes:jpeg,jpg,bmp,png,gif'
            ]);
        $status=['active','inactive'];
        $categories=Category::all();
        $category_ids=$categories->id;
        if(in_array($request->status,$status)){
            if(in_array($request->category_id,$category_ids))
            {
                $product=new product([
                    'name'=>$request['name'],
                    'code'=>$request->code,
                    'price'=>$request->price,
                    'status'=>$request->status,
                    'available_stock'=>$request->available_stock,
                    'category_id'=>$request->category_id
                    //'product_id'=>auth()->id(),
                ]);
                $product->save();
                if ($request->image) {
                    $this->saveImages($request->image, $prodcut->id);
                }
                return $this->index()->with([
                    'mes_suc' => 'product '. $product->name .' is added succesfully'
                ]);  
            }
            else{
                return $this->create()->with([
                    'mes_suc' => 'Please enter a valid Categoryid'
                ]); 
            }
        }
        else{
            return $this->create()->with([
                'mes_suc' => 'Please choose a valid status:active or inactive'
            ]); 
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if($product->status=='active')
        {
            return view('/product/show')->with(
            ['product' => $product
            ]); }
        else{
            return view('home');
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
        return view('/product/edit')->with(
            ['product' => $product
            ]);  
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
        $request->validate(['name'=>'required',
        'code'=> 'required',
        'price'=> 'required',
        'status'=> 'required',
        'available_stock'=> 'required',
        'category_id'=>'required',
        'image' => 'mimes:jpeg,jpg,bmp,png,gif'
        ]);
        $status=['active','inactive'];
        $category_ids=Category::where('id' ,'>' ,0)->pluck('id')->toArray();
        if(in_array($request->status,$status)){
            if(in_array($request->category_id,$category_ids))
            {
            $product->update([
            'name'=>$request['name'],
            'code'=>$request->code,
            'price'=>$request->price,
            'status'=>$request->status,
            'available_stock'=>$request->available_stock,
            'category_id'=>$request->category_id
            ]);
            if ($request->image) {
                $this->saveImages($request->image, $product->id);
            }
            return redirect('/product')->with([
                    'mes_suc' => 'Succesfully updated!'
                ]);  
            }
            else{
                return redirect('/product/create')->with([
                    'mes_suc' => 'Please enter a valid Categoryid'
                ]); 
            }
        }
        else{
            return redirect('/product/create')->with([
                'mes_suc' => 'Please choose a valid status:active or inactive'
            ]); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // abort_unless($user->role='admin',403);
        $old=$product->name;
        $product->forceDelete();
        return redirect('product')->with([
            'mes_suc' => 'product '. $old .' is deleted succesfully'
        ]);
    }
    public function saveImages($imageInput, $product_id)
    {
        $image = Image::make($imageInput);
        if ( $image->width() > $image->height() ) { // Landscape
            $image->widen(500)
                ->save(public_path() . "/img/products/" . $product_id . "_large.jpg");
            $image = Image::make($imageInput);
            $image->widen(120)
                ->save(public_path() . "/img/products/" . $product_id . "_thumb.jpg");
        }
        else { // Portrait
            $image->heighten(500)
                ->save(public_path() . "/img/products/" . $product_id . "_large.jpg");
            $image = Image::make($imageInput);
            $image->heighten(120)
                ->save(public_path() . "/img/products/" . $product_id . "_thumb.jpg");
        }

    }
    public function addToCart(Request $request)
    {
            $cart=Cart::firstOrCreate(['user_id'=>Auth::id(),
                'product_id'=>$request->product_id]);
            return view('/product/cartlist');
    }
    public static function cartItem()
    {
            $userId=Auth::id();
            return Cart::where('user_id',$userId)->count();
    }
    public static function cartList()
    {
            return view('/product/cartlist');
    }
    public function orderNow(Request $request)
    {
        $userId=Auth::id();
        $products=DB::table('carts')
        ->join('products','carts.product_id','=','products.id')
        ->where('carts.user_id',$userId)
        ->select('products.*')
        ->get();
        $total=0;
        $count=0;
        foreach($products as $product){
                $product_price=$product->price*$request->quantity[$count];
                $quantity=$request->quantity[$count];
                $total=$total+$product_price;
                $count=$count+1;    
        }
        return view('/product/ordernow',['products'=>$products,'total'=>$total,
        'product_prices'=>$product_price,'quantities'=>$quantity]);
        // return $request->quantity;
    }
    public function placeOrder(Request $request)
    { 
        // return $request->total;
        $order=new Order([
            'user_id'=>Auth::id(),
            'amount'=>$request->total,
            'status'=>"pending",
            'ordered_at'=>Carbon::now()
        ]);
        $order->save();
        $userId=Auth::id();
        $products=DB::table('carts')
        ->join('products','carts.product_id','=','products.id')
        ->where('carts.user_id',$userId)
        ->select('products.*')
        ->get();
        $total=0;
        foreach($products as $product){
            $product_price=$product->price*$request->quantity;
            $quantity=$request->quantity;
            $total=$total+$product_price;
        }
        foreach($products as $product)
        {
            $orderItem=new OrderItem([
            'order_id'=>Order::orderby('id','desc')->first()->id,
            'product_id'=>$product->id,
            'price'=>$product->price,
            'quantity'=>$request->quantity,
            'ordered_at'=>Carbon::now()
        ]);
        $orderItem->save();
        }
        $cart=Cart::where('user_id',Auth::id());
        $cart->delete();
        $this->sendMail();
        return redirect('product')->with(['msg'=>"Order placed succesfully"]);
    }
    public function sendMail()
    {
        \Mail::send('product\mail', array(
        'name' => Auth::user()->name,
        'email' => Auth::user()->email,
        'subject' => "Order Confirmation",
        'form_message' => "This is to inform you that your order is confirmed",
    ), function($message){
        $message->from("sridivyapervela357@gmail.com");
        $message->to(Auth::user()->email, 'Dear customer')->subject("Order Confirmation");
    });
    }
}
