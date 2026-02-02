<?php

namespace App\Domains\Financial\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Shared\Models\Country;

class Vat extends Model
{
    
    protected $table = 'vats';
    protected $fillable = ['country_id', 'rate', 'name'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

}