<?php
namespace App\Http\Controllers\Tenancy;

use App\Domains\Tenancy\Repositories\OrganisationRepository;
use App\Domains\Tenancy\Actions\CreateOrganisation;
use App\Domains\Tenancy\Actions\UpdateOrganisation;
use App\Http\Requests\StoreOrganisationRequest;
use App\Http\Requests\UpdateOrganisationRequest;

class OrganisationController {
    public function __construct(
        protected OrganisationRepository $repo,
        protected CreateOrganisation $create,
        protected UpdateOrganisation $update
    ) {}
    public function index()
    {
        return response()->json($this->repo->paginate());
    }
    public function store(StoreOrganisationRequest $r) {
        return $this->create->execute($r->validated());
    }

    public function update(UpdateOrganisationRequest $r, $id) {
        return $this->update->execute($r->validated(), $this->repo->find($id));
    }
}