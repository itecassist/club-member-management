<?php

namespace App\Domains\Content\Events;

class FaqCreated
{
    public function __construct(public readonly int $id) {}
}