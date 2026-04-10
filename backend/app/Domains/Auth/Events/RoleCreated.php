<?php

namespace App\Domains\Auth\Events;

class RoleCreated
{
    public function __construct(public readonly int $id, public readonly int $organisationId) {}
}