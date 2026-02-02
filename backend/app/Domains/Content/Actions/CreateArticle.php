<?php
namespace App\Domains\Content\Actions;
use App\Domains\Content\Repositories\ArticleRepository;
use App\Domains\Content\Models\Article;

class CreateArticle {
    public function __construct(protected ArticleRepository $repo) {}
    public function execute(array $data, Article $model = null): Article {
        $model = $this->repo->create($data);
        return $model;
    }
}