<?php

namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;

class Role extends Model
{
    use TenantScoped;

    protected $table = 'roles';
    protected $fillable = ['organisation_id', 'name', 'display_name', 'description', 'is_system'];

    /**
     * Permissions assigned to this role
     */
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permissions',
            'role_id',
            'permission_id'
        );
    }

    /**
     * Users assigned to this role
     */
    public function users()
    {
        return $this->belongsToMany(
            \App\Models\User::class,
            'user_roles',
            'role_id',
            'user_id'
        )->withPivot('organisation_id');
    }

    /**
     * Organisation this role belongs to
     */
    public function organisation()
    {
        return $this->belongsTo(
            \App\Domains\Tenancy\Models\Organisation::class,
            'organisation_id'
        );
    }
}
