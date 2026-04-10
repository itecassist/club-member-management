<?php

namespace App\Http\Controllers\Content;

use App\Domains\Content\Actions\CreateArticle;
use App\Domains\Content\Actions\DeleteArticle;
use App\Domains\Content\Actions\UpdateArticle;
use App\Domains\Content\DTOs\ArticleData;
use App\Domains\Content\Repositories\ArticleRepository;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Http\JsonResponse;

class ArticleController
{
    public function __construct(
        protected ArticleRepository $repo,
        protected CreateArticle $create,
        protected UpdateArticle $update,
        protected DeleteArticle $delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->repo->paginate());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->repo->findOrFail($id));
    }

    public function store(StoreArticleRequest $r): JsonResponse
    {
        $model = $this->create->execute(ArticleData::fromArray($r->validated()));
        return response()->json($model, 201);
    }

    public function update(UpdateArticleRequest $r, int $id): JsonResponse
    {
        $model = $this->update->execute(
            ArticleData::fromArray($r->validated()),
            $this->repo->findOrFail($id)
        );
        return response()->json($model);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->delete->execute($this->repo->findOrFail($id));
        return response()->json(null, 204);
    }
}