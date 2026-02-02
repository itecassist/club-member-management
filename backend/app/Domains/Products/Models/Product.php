<?php

namespace App\Domains\Products\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;
use App\Domains\Tenancy\Models\Organisation;
use App\Domains\Shared\Models\Lookup;
use App\Domains\Products\Models\ProductOption;
use App\Domains\Products\Models\ProductImage;
use App\Domains\Products\Models\ProductEventRule;
use App\Domains\Products\Models\ProductRecurringRule;

class Product extends Model
{
    use TenantScoped;
    protected $table = 'products';
    protected $fillable = ['organisation_id', 'lookup_id', 'name', 'code', 'description'];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

    public function lookup()
    {
        return $this->belongsTo(Lookup::class, 'lookup_id');
    }

    public function options()
    {
        return $this->hasMany(ProductOption::class, 'product_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function eventRules()
    {
        return $this->hasMany(ProductEventRule::class, 'product_id');
    }

    public function recurringRules()
    {
        return $this->hasMany(ProductRecurringRule::class, 'product_id');
    }

}