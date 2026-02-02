<?php
namespace App\Domains\Content\Actions;
use App\Domains\Content\Repositories\ArticleRepository;
use App\Domains\Content\Models\Article;

class UpdateArticle {
    public function __construct(protected ArticleRepository $repo) {}
    public function execute(array $data, Article $model = null): Article {
        $model = $this->repo->update($model, $data);
        return $model;
    }
}