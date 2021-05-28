<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    use HasFactory;
    public function order(){
        return $this->belongsTo('App\Models\Order');
    }

    public function products(){
        return $this->belongsToMany('App\Models\Product');
    }

    protected $fillable = [
        'order_id',
        'price',
        'quantity',
        'product_id',
    ];
}
