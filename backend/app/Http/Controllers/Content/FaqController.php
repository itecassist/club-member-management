<?php
namespace App\Http\Controllers\Content;

use App\Domains\Content\Repositories\FaqRepository;
use App\Domains\Content\Actions\CreateFaq;
use App\Domains\Content\Actions\UpdateFaq;
use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;

class FaqController {
    public function __construct(
        protected FaqRepository $repo,
        protected CreateFaq $create,
        protected UpdateFaq $update
    ) {}
    public function index()
    {
        return response()->json($this->repo->paginate());
    }
    public function store(StoreFaqRequest $r) {
        return $this->create->execute($r->validated());
    }

    public function update(UpdateFaqRequest $r, $id) {
        return $this->update->execute($r->validated(), $this->repo->find($id));
    }
}