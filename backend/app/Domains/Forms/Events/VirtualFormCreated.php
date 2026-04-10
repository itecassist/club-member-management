<?php

namespace App\Domains\Forms\Events;

class VirtualFormCreated
{
    public function __construct(public readonly int $id, public readonly int $organisationId) {}
}