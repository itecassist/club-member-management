<?php

namespace App\Domains\Members\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Tenancy\TenantScoped;
use App\Domains\Tenancy\Models\Organisation;
use App\Domains\Auth\Models\User;
use App\Domains\Members\Models\Address;
use App\Domains\Members\Models\Contact;

class Member extends Model
{
    use TenantScoped;
    protected $table = 'members';
    protected $fillable = ['user_id', 'organisation_id', 'title', 'first_name', 'last_name', 'email', 'mobile_phone', 'date_of_birth', 'gender', 'member_number', 'joined_at', 'is_active', 'roles', 'last_login_at'];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

}