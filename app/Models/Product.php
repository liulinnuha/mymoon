<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'discount', 'category_id', 'stock_quantity', 'type', 'weight', 'varian', 'code', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        $this->belongsToMany(Images::class, 'product_image')->withTimestamps();
    }
}
