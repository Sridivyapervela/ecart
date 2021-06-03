<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'price',
        'status',
        'available_stock',
        'category_id',
    ];
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function order_item(){
        return $this->belongsTo('App\Models\OrderItem');
    }
}
