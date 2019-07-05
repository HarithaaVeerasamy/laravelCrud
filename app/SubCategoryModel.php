<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategoryModel extends Model
{
     protected $table = 'subcategory';

    protected $fillable = [
        'cate_id', 'subcate_name', 'status','created_at','updated_at',
    ];
}
