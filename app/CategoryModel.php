<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'category';

     protected $fillable = [
        'category_name', 'status'
    ];
}
