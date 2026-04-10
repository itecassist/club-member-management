<?php

namespace App\Domains\Content\Repositories;

use App\Domains\Content\Models\Article;
use App\Domains\Content\DTOs\ArticleData;

class ArticleRepository
{
    public function create(ArticleData $data): Article
    {
        return Article::create($data->toArray());
    }

    public function update(Article $model, ArticleData $data): Article
    {
        $model->update($data->toArray());
        return $model;
    }

    public function find(int $id): ?Article
    {
        return Article::find($id);
    }

    public function findOrFail(int $id): Article
    {
        return Article::findOrFail($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Article::paginate($perPage);
    }

    public function delete(Article $model): void
    {
        $model->delete();
    }
}