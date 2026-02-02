<?php

namespace App\Domains\Subscriptions\Policies;

use App\Domains\Subscriptions\Models\Subscription;

class SubscriptionPolicy
{

    public function view(\App\Models\User $user, Subscription $Subscription)
    {
        return $user->organisation_id === $Subscription->organisation_id;
    }

    public function create(\App\Models\User $user, Subscription $Subscription)
    {
        return $user->organisation_id === $Subscription->organisation_id;
    }

    public function update(\App\Models\User $user, Subscription $Subscription)
    {
        return $user->organisation_id === $Subscription->organisation_id;
    }

    public function delete(\App\Models\User $user, Subscription $Subscription)
    {
        return $user->organisation_id === $Subscription->organisation_id;
    }

}