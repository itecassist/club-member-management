<?php

namespace App\Domains\Content\Actions;

use App\Domains\Content\Repositories\ArticleRepository;
use App\Domains\Content\Models\Article;

class DeleteArticle
{
    public function __construct(protected ArticleRepository $repo) {}

    public function execute(Article $model): void
    {
        $this->repo->delete($model);
    }
}