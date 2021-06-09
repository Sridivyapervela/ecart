<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $categories = Category::orderBy("created_at", "DESC")->paginate(25);
    return view("/admin/categories/index")->with(["categories" => $categories]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view("/admin/categories/create");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $category_codes = Category::where("id", ">", 0)
      ->pluck("code")
      ->toArray();
    $request->validate([
      "name" => "required",
      "code" => ["required", Rule::notIn($category_codes)],
    ]);
    $category = new Category([
      "name" => $request["name"],
      "code" => $request->code,
    ]);
    $category->save();
    return $this->index()->with([
      "mes_suc" => "category " . $category->name . " is added succesfully",
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Category $category)
  {
    $user = auth()->user();
    return view("/admin/categories/show")->with([
      "category" => $category,
      "user" => $user,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Category $category)
  {
    return view("/admin/categories/edit")->with(["category" => $category]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Category $category)
  {
    $category_codes = Category::where("id", ">", 0)
      ->pluck("code")
      ->toArray();
    $request->validate([
      "name" => "required",
      "code" => ["required", Rule::notIn($category_codes)],
    ]);

    $category->update([
      "name" => $request["name"],
      "code" => $request->code,
    ]);
    return redirect("/admin/categories");
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Category $category)
  {
    $category->delete();
    return redirect("/admin/categories");
  }
}
