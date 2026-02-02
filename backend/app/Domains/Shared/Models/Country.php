<?php

namespace App\Domains\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Shared\Models\Zone;

class Country extends Model
{
    
    protected $table = 'countries';
    protected $fillable = ['name', 'iso_code_2', 'iso_code_3', 'currency_code', 'currency_symbol', 'symbol_left', 'decimal_place', 'decimal_point', 'thousands_point'];

    public function zones()
    {
        return $this->hasMany(Zone::class, 'country_id');
    }

}