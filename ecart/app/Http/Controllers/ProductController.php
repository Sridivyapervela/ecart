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

class ProductController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('admin')->except(['show','index','addToCart','cartItem','cartList','orderNow']);
    //     $this->middleware('auth')->except(['show','index','addToCart','cartItem','cartList','orderNow']);
    // }
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
        $categories=Category::all();
        $category_ids=$categories->id;
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
                $this->saveImages($request->image, $prodcut->id);
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
        abort_unless($user->role='admin',403);
        $old=$product->name;
        $product->delete();
        return $this->index();
        // ->with([
        //     'mes_suc' => 'product '. $old .' is deleted succesfully'
        //]);
    }
    public function saveImages($imageInput, $product_id)
    {
        $image = Image::make($imageInput);
        if ( $image->width() > $image->height() ) { // Landscape
            $image->widen(400)
                ->save(public_path() . "/img/products/" . $product_id . "_large.jpg");
            $image = Image::make($imageInput);
            $image->widen(60)
                ->save(public_path() . "/img/products/" . $product_id . "_thumb.jpg");
        }
        else { // Portrait
            $image->heighten(400)
                ->save(public_path() . "/img/products/" . $product_id . "_large.jpg");
            $image = Image::make($imageInput);
            $image->heighten(60)
                ->save(public_path() . "/img/products/" . $product_id . "_thumb.jpg");
        }

    }
    public function addToCart(Request $request)
    {
        if($request->session()->has('user'))
        {
            $cart=new Cart([
                'user_id'=>$request->session()->get('user')->id,
                'product_id'=>$request->product_id
            ]);
            $cart->save();
            return view('/cartlist');
        }
        else{
            return redirect('/login');
        }
    }
    public function cartItem()
    {
            $userId=Session::get('user')->id;
            return Cart::where('user_id','$userId')->count();
    }
    public static function cartList()
    {
        if(Session::has('user'))
        {
            $userId=Session::get('user')->id;
            $products=DB::table('carts')
            ->join('products','carts.product_id','=','products.id')
            ->where('carts.user_id',$userId)
            ->select('products.*')
            ->get();
            return view('/cartlist',['products'=>$products]);

        }
        else{
            return redirect('/login');
        }
    }
    public function orderNow(Request $request)
    {
        $userId=Session::get('user')->id;
        $products=$request->products;
        foreach($products as $product){
            $product_price=$product->price*$request->quantity;
            $quantity=$request->quantity;
        }
        $total=$products->sum();
        return view('/placeorder',['products'=>$products,'total'=>$total,
        'product_prices'=>$product_price,'quantities'=>$quantity]);
    }
    public function placeOrder(Request $request)
    {
        $order=new Order([
            'user_id'=>Session::get('user')->id,
            'amount'=>$request->total,
            'status'=>"pending",
        ]);
        $order->save();
        $orderItem=new OrderItem([
            'order_id'=>Order::first()->id,
            'product_id'=>$request->product_id,
            'price'=>,
            'quantity'=>,
            'ordered_at'=>
        ]);
        $orderItem->save();
        $cart=Cart::where('user_id','=','Session::get('user')->id');
        $cart->delete();
        return view('home')->with(['msg'=>"Order placed succesfully"]);
    }
}
