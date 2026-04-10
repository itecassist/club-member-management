<?php

namespace App\Domains\Content\Actions;

use App\Domains\Content\Repositories\FaqRepository;
use App\Domains\Content\Models\Faq;

class DeleteFaq
{
    public function __construct(protected FaqRepository $repo) {}

    public function execute(Faq $model): void
    {
        $this->repo->delete($model);
    }
}