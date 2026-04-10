<?php

namespace App\Domains\Shared\Actions;

use App\Domains\Shared\Repositories\CountryRepository;
use App\Domains\Shared\Models\Country;

class DeleteCountry
{
    public function __construct(protected CountryRepository $repo) {}

    public function execute(Country $model): void
    {
        $this->repo->delete($model);
    }
}