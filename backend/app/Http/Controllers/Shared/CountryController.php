<?php
namespace App\Http\Controllers\Shared;

use App\Domains\Shared\Repositories\CountryRepository;
use App\Domains\Shared\Actions\CreateCountry;
use App\Domains\Shared\Actions\UpdateCountry;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;

class CountryController {
    public function __construct(
        protected CountryRepository $repo,
        protected CreateCountry $create,
        protected UpdateCountry $update
    ) {}
    public function index()
    {
        return response()->json($this->repo->paginate());
    }
    public function store(StoreCountryRequest $r) {
        return $this->create->execute($r->validated());
    }

    public function update(UpdateCountryRequest $r, $id) {
        return $this->update->execute($r->validated(), $this->repo->find($id));
    }
}