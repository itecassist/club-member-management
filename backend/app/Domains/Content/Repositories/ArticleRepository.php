<?php

namespace App\Domains\Content\Repositories;

use App\Domains\Content\Models\Article;

class ArticleRepository
{
    public function create(array $data): Article
    {
        return Article::create($data);
    }

    public function update(Article $model, array $data): Article
    {
        $model->update($data);
        return $model;
    }

    public function find(int $id): ?Article
    {
        return Article::find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Article::paginate($perPage);
    }
}