<?php

namespace App\Domains\Financial\Policies;

use App\Domains\Financial\Models\AccountBalance;

class AccountBalancePolicy
{

    public function view(\App\Models\User $user, AccountBalance $AccountBalance)
    {
        return $user->organisation_id === $AccountBalance->organisation_id;
    }

    public function update(\App\Models\User $user, AccountBalance $AccountBalance)
    {
        return $user->organisation_id === $AccountBalance->organisation_id;
    }

}