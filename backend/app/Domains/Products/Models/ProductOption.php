<?php

namespace App\Domains\Products\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Products\Models\Product;
use App\Domains\Products\Models\ProductOptionVariant;

class ProductOption extends Model
{
    
    protected $table = 'product_options';
    protected $fillable = ['product_id', 'name', 'type', 'is_required'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductOptionVariant::class, 'product_option_id');
    }

}