<?php

namespace App\Domains\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Shared\Models\Country;

class Zone extends Model
{
    
    protected $table = 'zones';
    protected $fillable = ['country_id', 'name', 'code'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

}