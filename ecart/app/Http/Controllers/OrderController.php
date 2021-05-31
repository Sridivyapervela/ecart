<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('admin')->except(['show','index']);
    //     $this->middleware('auth')->except(['show','index']);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $orders=Order::orderBy('created_at','DESC')->paginate(50);
        return view('/order/index')->with(['orders'=>$orders]);   
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('/order/edit')->with(
            ['order' => $order
            ]);
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
        'status'=> 'required',
        ]);
        $status=['success','failed'];
        if(in_array($request->status,$status)){
            $order->update([
            'status'=>$request->status,
            ]);
            return redirect('/order')->with([
                    'mes_suc' => 'Succesfully updated!'
                ]);   
            }
        else{
            return redirect('/order')->with([
                'mes_suc' => 'Please choose a valid status:Success or failed'
            ]); 
        }
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
