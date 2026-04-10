<?php

namespace App\Domains\Orders\Events;

class OrderCreated
{
    public function __construct(public readonly int $id, public readonly int $organisationId) {}
}