<?php

namespace App\Domains\Tenancy\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;
use App\Domains\Tenancy\Models\Organisation;

class OrganisationList extends Model
{
    use TenantScoped;
    protected $table = 'organisation_lists';
    protected $fillable = ['organisation_id', 'name', 'description'];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

}