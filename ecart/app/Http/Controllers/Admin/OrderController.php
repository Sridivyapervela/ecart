<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $orders = Order::orderBy("created_at", "DESC")->paginate(50);
    return view("/admin/orders/index")->with(["orders" => $orders]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function edit(Order $order)
  {
    return view("/admin/orders/edit")->with(["order" => $order]);
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
    $order->update([
      "status" => $request->status,
    ]);
    return redirect("/admin/orders")->with([
      "mes_suc" => "Succesfully updated!",
    ]);
  }
}
