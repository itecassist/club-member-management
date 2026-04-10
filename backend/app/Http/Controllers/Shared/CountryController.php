<?php

namespace App\Http\Controllers\Shared;

use App\Domains\Shared\Actions\CreateCountry;
use App\Domains\Shared\Actions\DeleteCountry;
use App\Domains\Shared\Actions\UpdateCountry;
use App\Domains\Shared\DTOs\CountryData;
use App\Domains\Shared\Repositories\CountryRepository;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use Illuminate\Http\JsonResponse;

class CountryController
{
    public function __construct(
        protected CountryRepository $repo,
        protected CreateCountry $create,
        protected UpdateCountry $update,
        protected DeleteCountry $delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->repo->paginate());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->repo->findOrFail($id));
    }

    public function store(StoreCountryRequest $r): JsonResponse
    {
        $model = $this->create->execute(CountryData::fromArray($r->validated()));
        return response()->json($model, 201);
    }

    public function update(UpdateCountryRequest $r, int $id): JsonResponse
    {
        $model = $this->update->execute(
            CountryData::fromArray($r->validated()),
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