<?php

namespace App\Domains\Products\Events;

class ProductCreated
{
    public function __construct(public readonly int $id, public readonly int $organisationId) {}
}