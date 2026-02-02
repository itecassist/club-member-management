<?php

namespace App\Domains\Tenancy\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Members\Models\Member;
use App\Domains\Tenancy\Models\OrganisationConfig;
use App\Domains\Tenancy\Models\OrganisationConfigAdmin;
use App\Domains\Tenancy\Models\OrganisationConfigFinancial;
use App\Domains\Tenancy\Models\OrganisationConfigMember;
use App\Domains\Tenancy\Models\OrganisationConfigSubscription;
use App\Domains\Tenancy\Models\OrganisationList;
use App\Domains\Tenancy\Models\OrganisationRole;

class Organisation extends Model
{
    
    protected $table = 'organisations';
    protected $fillable = ['name', 'seo_name', 'email', 'phone', 'logo', 'website', 'description', 'free_trail', 'free_trail_end_date', 'billing_policy', 'is_active'];

    public function members()
    {
        return $this->hasMany(Member::class, 'organisation_id');
    }

    public function configs()
    {
        return $this->hasMany(OrganisationConfig::class, 'organisation_id');
    }

    public function configAdmins()
    {
        return $this->hasMany(OrganisationConfigAdmin::class, 'organisation_id');
    }

    public function configFinancials()
    {
        return $this->hasMany(OrganisationConfigFinancial::class, 'organisation_id');
    }

    public function configMembers()
    {
        return $this->hasMany(OrganisationConfigMember::class, 'organisation_id');
    }

    public function configSubscriptions()
    {
        return $this->hasMany(OrganisationConfigSubscription::class, 'organisation_id');
    }

    public function lists()
    {
        return $this->hasMany(OrganisationList::class, 'organisation_id');
    }

    public function roles()
    {
        return $this->hasMany(OrganisationRole::class, 'organisation_id');
    }

}