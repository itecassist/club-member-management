<?php

namespace App\Domains\Shared\Actions;

use App\Domains\Shared\Repositories\CountryRepository;
use App\Domains\Shared\Models\Country;
use App\Domains\Shared\DTOs\CountryData;

class UpdateCountry
{
    public function __construct(protected CountryRepository $repo) {}

    public function execute(CountryData $data, Country $model): Country
    {
        return $this->repo->update($model, $data);
    }
}