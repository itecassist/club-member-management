<?php

namespace App\Domains\Tenancy\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;
use App\Domains\Tenancy\Models\Organisation;

class OrganisationRole extends Model
{
    use TenantScoped;
    protected $table = 'organisation_roles';
    protected $fillable = ['organisation_id', 'name', 'description'];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

}