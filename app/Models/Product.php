<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'maker_name',
        'price',
        'stock',
        'comment',
        'img_path',
        'created_at',
        'updated_at',
        ];

}
