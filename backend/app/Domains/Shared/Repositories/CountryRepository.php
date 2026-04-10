<?php

namespace App\Domains\Shared\Repositories;

use App\Domains\Shared\Models\Country;
use App\Domains\Shared\DTOs\CountryData;

class CountryRepository
{
    public function create(CountryData $data): Country
    {
        return Country::create($data->toArray());
    }

    public function update(Country $model, CountryData $data): Country
    {
        $model->update($data->toArray());
        return $model;
    }

    public function find(int $id): ?Country
    {
        return Country::find($id);
    }

    public function findOrFail(int $id): Country
    {
        return Country::findOrFail($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Country::paginate($perPage);
    }

    public function delete(Country $model): void
    {
        $model->delete();
    }
}