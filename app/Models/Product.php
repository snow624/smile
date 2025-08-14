<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // ← ここを追加！
    protected $fillable = [
        'product_name',
        'maker_name',
        'price',
        'stock',
        'comment',
        'image_path',
    ];
    
}
