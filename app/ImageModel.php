<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'product_id', 'image_path','created_at','updated_at',
    ];
}
