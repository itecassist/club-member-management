<?php

namespace App\Domains\Members\Policies;

use App\Domains\Members\Models\Member;

class MemberPolicy
{

    public function view(\App\Models\User $user, Member $Member)
    {
        return $user->organisation_id === $Member->organisation_id;
    }

    public function update(\App\Models\User $user, Member $Member)
    {
        return $user->organisation_id === $Member->organisation_id;
    }

    public function delete(\App\Models\User $user, Member $Member)
    {
        return $user->organisation_id === $Member->organisation_id;
    }

}