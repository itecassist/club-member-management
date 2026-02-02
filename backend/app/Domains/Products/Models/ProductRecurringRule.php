<?php

namespace App\Domains\Products\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Products\Models\Product;

class ProductRecurringRule extends Model
{
    
    protected $table = 'product_recurring_rules';
    protected $fillable = ['product_id', 'interval', 'frequency'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}