<?php

namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;

class Role extends Model
{
    use TenantScoped;
    protected $table = 'roles';
    protected $fillable = ['organisation_id', 'name', 'display_name', 'description', 'is_system'];

}