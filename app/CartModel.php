<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    protected $table = 'cart';

     protected $fillable = [
        'product_id', 'user_id', 'quantity','sub_total',
    ];
}
