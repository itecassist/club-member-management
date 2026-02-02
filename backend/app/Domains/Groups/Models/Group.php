<?php

namespace App\Domains\Groups\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;

class Group extends Model
{
    use TenantScoped;
    protected $table = 'groups';
    protected $fillable = ['organisation_id', 'name', 'type', 'description', 'primary_admin_id', 'max_members', 'is_active'];

}