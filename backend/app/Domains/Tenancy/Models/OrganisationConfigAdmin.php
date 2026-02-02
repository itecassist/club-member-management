<?php

namespace App\Domains\Tenancy\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;
use App\Domains\Tenancy\Models\Organisation;
use App\Domains\Members\Models\Member;
use App\Domains\Tenancy\Models\OrganisationRole;

class OrganisationConfigAdmin extends Model
{
    use TenantScoped;
    protected $table = 'organisation_config_admins';

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function role()
    {
        return $this->belongsTo(OrganisationRole::class, 'role_id');
    }

}