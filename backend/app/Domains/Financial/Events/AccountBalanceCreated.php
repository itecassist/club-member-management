<?php

namespace App\Domains\Financial\Events;

class AccountBalanceCreated
{
    public function __construct(public readonly int $id, public readonly int $organisationId) {}
}