<?php

namespace App\Domains\Shared\Events;

class CountryCreated
{
    public function __construct(public readonly int $id) {}
}