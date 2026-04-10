<?php

namespace App\Http\Controllers\Content;

use App\Domains\Content\Actions\CreateFaq;
use App\Domains\Content\Actions\DeleteFaq;
use App\Domains\Content\Actions\UpdateFaq;
use App\Domains\Content\DTOs\FaqData;
use App\Domains\Content\Repositories\FaqRepository;
use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use Illuminate\Http\JsonResponse;

class FaqController
{
    public function __construct(
        protected FaqRepository $repo,
        protected CreateFaq $create,
        protected UpdateFaq $update,
        protected DeleteFaq $delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->repo->paginate());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->repo->findOrFail($id));
    }

    public function store(StoreFaqRequest $r): JsonResponse
    {
        $model = $this->create->execute(FaqData::fromArray($r->validated()));
        return response()->json($model, 201);
    }

    public function update(UpdateFaqRequest $r, int $id): JsonResponse
    {
        $model = $this->update->execute(
            FaqData::fromArray($r->validated()),
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