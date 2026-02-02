<?php
namespace App\Domains\Shared\Actions;
use App\Domains\Shared\Repositories\CountryRepository;
use App\Domains\Shared\Models\Country;

class UpdateCountry {
    public function __construct(protected CountryRepository $repo) {}
    public function execute(array $data, Country $model = null): Country {
        $model = $this->repo->update($model, $data);
        return $model;
    }
}