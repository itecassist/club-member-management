<?php
namespace App\Http\Controllers\Content;

use App\Domains\Content\Repositories\ArticleRepository;
use App\Domains\Content\Actions\CreateArticle;
use App\Domains\Content\Actions\UpdateArticle;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class ArticleController {
    public function __construct(
        protected ArticleRepository $repo,
        protected CreateArticle $create,
        protected UpdateArticle $update
    ) {}
    public function index()
    {
        return response()->json($this->repo->paginate());
    }
    public function store(StoreArticleRequest $r) {
        return $this->create->execute($r->validated());
    }

    public function update(UpdateArticleRequest $r, $id) {
        return $this->update->execute($r->validated(), $this->repo->find($id));
    }
}