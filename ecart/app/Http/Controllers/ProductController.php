<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['show','index']);
        $this->middleware('auth')->except(['show','index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $products=Product::orderBy('created_at','DESC')->paginate(10);
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
        return view('/product/show')->with(
            ['product' => $product
            ]); 
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
            return redirect('/products'); 
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
}
