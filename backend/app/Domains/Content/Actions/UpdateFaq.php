<?php
namespace App\Domains\Content\Actions;
use App\Domains\Content\Repositories\FaqRepository;
use App\Domains\Content\Models\Faq;

class UpdateFaq {
    public function __construct(protected FaqRepository $repo) {}
    public function execute(array $data, Faq $model = null): Faq {
        $model = $this->repo->update($model, $data);
        return $model;
    }
}