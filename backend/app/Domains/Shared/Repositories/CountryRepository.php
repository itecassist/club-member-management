<?php

namespace App\Domains\Shared\Repositories;

use App\Domains\Shared\Models\Country;

class CountryRepository
{
    public function create(array $data): Country
    {
        return Country::create($data);
    }

    public function update(Country $model, array $data): Country
    {
        $model->update($data);
        return $model;
    }

    public function find(int $id): ?Country
    {
        return Country::find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Country::paginate($perPage);
    }
}