<?php

namespace App\Domains\Shared\Actions;

use App\Domains\Shared\Repositories\CountryRepository;
use App\Domains\Shared\Models\Country;
use App\Domains\Shared\DTOs\CountryData;
use App\Domains\Shared\Events\CountryCreated;

class CreateCountry
{
    public function __construct(protected CountryRepository $repo) {}

    public function execute(CountryData $data): Country
    {
        $model = $this->repo->create($data);
        event(new CountryCreated($model->id));
        return $model;
    }
}