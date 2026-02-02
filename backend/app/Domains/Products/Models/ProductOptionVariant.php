<?php

namespace App\Domains\Products\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Products\Models\ProductOption;

class ProductOptionVariant extends Model
{
    
    protected $table = 'product_option_variants';
    protected $fillable = ['product_option_id', 'name', 'price_modifier'];

    public function productOption()
    {
        return $this->belongsTo(ProductOption::class, 'product_option_id');
    }

}