<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $users = User::orderBy("created_at", "DESC")->paginate(25);
    return view("/admin/users/index")->with(["users" => $users]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view("/admin/users/create");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      "first_name" => "required",
      "last_name" => "required",
      "email" => "required",
      "password" => "required",
    ]);
    $user = new User([
      "first_name" => $request->first_name,
      "last_name" => $request->last_name,
      "email" => $request->email,
      "password" => Hash::make($request->password),
      // "user_id" => auth()->id(),
    ]);
    $user->save();
    return redirect("/admin/users")->with([
      "mes_suc" => "User " . $user->name . " is added succesfully",
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(User $user)
  {
    return view("/users/show")->with(["user" => $user]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user)
  {
    return view("/admin/users/edit")->with(["user" => $user]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, User $user)
  {
    $request->validate([
      "first_name" => "required",
      "last_name" => "required",
      "email" => "required",
    ]);
    $user->update([
      "first_name" => $request->first_name,
      "last_name" => $request->last_name,
      "email" => $request->email,
    ]);
    return redirect("/admin/users")->with([
      "mes_suc" => "User " . $user->first_name . " is updated succesfully",
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    $user->delete();
    return redirect("/admin/users");
  }
}
