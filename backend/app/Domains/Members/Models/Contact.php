<?php

namespace App\Domains\Members\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    
    protected $table = 'contacts';
    protected $fillable = ['contactable_type', 'contactable_id', 'name', 'email', 'mobile_phone', 'relation'];

    public function contactable()
    {
        return $this->morphTo();
    }

}