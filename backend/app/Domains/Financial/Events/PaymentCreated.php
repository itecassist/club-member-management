<?php

namespace App\Domains\Financial\Events;

class PaymentCreated
{
    public function __construct(public readonly int $id, public readonly int $organisationId) {}
}