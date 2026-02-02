<?php

namespace App\Domains\Orders\Policies;

use App\Domains\Orders\Models\Order;

class OrderPolicy
{

    public function view(\App\Models\User $user, Order $Order)
    {
        return $user->organisation_id === $Order->organisation_id;
    }

    public function update(\App\Models\User $user, Order $Order)
    {
        return $user->organisation_id === $Order->organisation_id;
    }

    public function delete(\App\Models\User $user, Order $Order)
    {
        return $user->organisation_id === $Order->organisation_id;
    }

}