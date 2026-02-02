<?php

namespace App\Domains\Products\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    
    protected $table = 'product_categories';
    protected $fillable = ['name', 'description'];

}