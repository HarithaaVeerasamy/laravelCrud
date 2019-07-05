<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'order';

    protected $fillable = [
        'order_id', 'product_id', 'quantity','sub_total','created_at','updated_at',
    ];
}
