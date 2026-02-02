<?php

namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;

class UserRole extends Model
{
    use TenantScoped;
    protected $table = 'user_roles';
    protected $fillable = ['user_id', 'role_id', 'organisation_id'];

}