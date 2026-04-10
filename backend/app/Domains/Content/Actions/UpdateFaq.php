<?php

namespace App\Domains\Content\Actions;

use App\Domains\Content\Repositories\FaqRepository;
use App\Domains\Content\Models\Faq;
use App\Domains\Content\DTOs\FaqData;

class UpdateFaq
{
    public function __construct(protected FaqRepository $repo) {}

    public function execute(FaqData $data, Faq $model): Faq
    {
        return $this->repo->update($model, $data);
    }
}