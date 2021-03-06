<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function order_items(){
        return $this->hasMany('App\Models\OrderItem');
    }
    
    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'available_stock',
        'ordered_at',
    ];
}
