<?php

namespace App\Domains\Content\Actions;

use App\Domains\Content\Repositories\ArticleRepository;
use App\Domains\Content\Models\Article;
use App\Domains\Content\DTOs\ArticleData;
use App\Domains\Content\Events\ArticleCreated;

class CreateArticle
{
    public function __construct(protected ArticleRepository $repo) {}

    public function execute(ArticleData $data): Article
    {
        $model = $this->repo->create($data);
        event(new ArticleCreated($model->id));
        return $model;
    }
}