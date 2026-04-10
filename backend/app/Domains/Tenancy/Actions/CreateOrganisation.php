<?php

namespace App\Domains\Tenancy\Actions;

use App\Domains\Tenancy\Repositories\OrganisationRepository;
use App\Domains\Tenancy\Models\Organisation;
use App\Domains\Tenancy\DTOs\OrganisationData;
use App\Domains\Tenancy\Events\OrganisationCreated;

class CreateOrganisation
{
    public function __construct(protected OrganisationRepository $repo) {}

    public function execute(OrganisationData $data): Organisation
    {
        $model = $this->repo->create($data);
        event(new OrganisationCreated($model->id));
        return $model;
    }
}