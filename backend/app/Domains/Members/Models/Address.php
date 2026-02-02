<?php

namespace App\Domains\Members\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Shared\Models\Country;
use App\Domains\Shared\Models\Zone;

class Address extends Model
{
    
    protected $table = 'addresses';
    protected $fillable = ['addressable_type', 'addressable_id', 'line_1', 'line_2', 'line_3', 'line_4', 'postcode', 'country_id', 'zone_id'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function addressable()
    {
        return $this->morphTo();
    }

}