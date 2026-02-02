<?php

namespace App\Domains\Shared\Models;

use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{
    
    protected $table = 'lookups';
    protected $fillable = ['type', 'key', 'value'];

}