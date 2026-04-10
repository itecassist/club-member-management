<?php

namespace App\Domains\Content\Events;

class ArticleCreated
{
    public function __construct(public readonly int $id) {}
}