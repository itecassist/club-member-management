<?php

namespace App\Domains\Members\Events;

class MemberCreated
{
    public function __construct(public int $id, public int $organisation_id) {}
}