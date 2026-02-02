<?php

namespace App\Domains\Products\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Products\Models\Product;

class ProductEventRule extends Model
{
    
    protected $table = 'product_event_rules';
    protected $fillable = ['product_id', 'event_name', 'action'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}