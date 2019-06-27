<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'product_name', 'category', 'subcategory','qty','status','created_at','updated_at',
    ];

    
}
