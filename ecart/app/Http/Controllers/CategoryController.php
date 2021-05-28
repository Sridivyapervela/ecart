<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\Product;


use Illuminate\Http\Request;

class CategoryController extends Controller
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
        $categories=Category::orderBy('created_at','DESC')->paginate(10);
        return view('/category/index')->with(['categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/category/create');
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
            ]);
        $category=new category([
            'name'=>$request['name'],
            'code'=>$request->code,
           // 'category_id'=>auth()->id(),
        ]);
        $category->save();
        return $this->index()->with([
            'mes_suc' => 'category '. $category->name .' is added succesfully'
        ]);  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $user=auth()->user();
        return view('/category/show')->with(
            ['category' => $category,
            'user'=>$user,
            ]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('/category/edit')->with(
            ['category' => $category
            ]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate(['name'=>'required',
        'code' => 'required',
        ]);
    
        $category->update([
        'name'=>$request['name'],
        'code'=>$request->code
    ]);
    return redirect('/index'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        abort_unless($category->role='admin',403);
        $old=$category->name;
        $category->delete();
        return redirect('/index');
    }
}
