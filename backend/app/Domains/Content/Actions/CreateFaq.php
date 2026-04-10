<?php

namespace App\Domains\Content\Actions;

use App\Domains\Content\Repositories\FaqRepository;
use App\Domains\Content\Models\Faq;
use App\Domains\Content\DTOs\FaqData;
use App\Domains\Content\Events\FaqCreated;

class CreateFaq
{
    public function __construct(protected FaqRepository $repo) {}

    public function execute(FaqData $data): Faq
    {
        $model = $this->repo->create($data);
        event(new FaqCreated($model->id));
        return $model;
    }
}