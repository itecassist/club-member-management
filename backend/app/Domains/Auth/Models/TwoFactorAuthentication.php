<?php

namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class TwoFactorAuthentication extends Model
{
    
    protected $table = 'two_factor_authentications';
    protected $fillable = ['user_id', 'secret', 'recovery_codes', 'enabled_at'];

}