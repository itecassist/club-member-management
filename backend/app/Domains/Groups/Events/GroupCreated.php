<?php

namespace App\Domains\Groups\Events;

class GroupCreated
{
    public function __construct(public readonly int $id, public readonly int $organisationId) {}
}