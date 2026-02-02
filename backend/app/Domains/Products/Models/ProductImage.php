<?php

namespace App\Domains\Products\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Products\Models\Product;

class ProductImage extends Model
{
    
    protected $table = 'product_images';
    protected $fillable = ['product_id', 'path', 'is_primary'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}