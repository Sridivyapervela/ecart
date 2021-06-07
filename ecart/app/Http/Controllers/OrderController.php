<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
  public function __construct()
  {
    // $this->middleware('admin')->except(['show','index']);
    $this->middleware("auth")->except(["show", "index"]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $orders = Order::orderBy("created_at", "DESC")->paginate(50);
    return view("/orders/index")->with(["orders" => $orders]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function show(Order $order)
  {
    return view("/orders/show")->with(["order" => $order]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function edit(Order $order)
  {
    return view("/orders/edit")->with(["order" => $order]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Order $order)
  {
    $request->validate([
      "status" => ["required", Rule::in(["success", "failed"])],
    ]);
    // $status=['success','failed'];
    // if(in_array($request->status,$status)){
    $order->update([
      "status" => $request->status,
    ]);
    return redirect("/orders")->with([
      "mes_suc" => "Succesfully updated!",
    ]);
    //     }
    // else{
    //     return redirect('/orders')->with([
    //         'mes_suc' => 'Please choose a valid status:Success or failed'
    //     ]);
    // }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function destroy(Order $order)
  {
    //
  }
}
