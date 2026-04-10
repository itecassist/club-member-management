<?php

namespace App\Domains\Auth\Events;

class PermissionCreated
{
    public function __construct(public readonly int $id) {}
}