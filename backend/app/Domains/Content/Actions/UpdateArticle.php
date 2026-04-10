<?php

namespace App\Domains\Content\Actions;

use App\Domains\Content\Repositories\ArticleRepository;
use App\Domains\Content\Models\Article;
use App\Domains\Content\DTOs\ArticleData;

class UpdateArticle
{
    public function __construct(protected ArticleRepository $repo) {}

    public function execute(ArticleData $data, Article $model): Article
    {
        return $this->repo->update($model, $data);
    }
}