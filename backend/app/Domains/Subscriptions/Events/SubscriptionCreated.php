<?php

namespace App\Domains\Subscriptions\Events;

class SubscriptionCreated
{
    public function __construct(public readonly int $id, public readonly int $organisationId) {}
}