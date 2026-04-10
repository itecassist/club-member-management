<?php

namespace App\Domains\Tenancy\Actions;

use App\Domains\Tenancy\Repositories\OrganisationRepository;
use App\Domains\Tenancy\Models\Organisation;
use App\Domains\Tenancy\DTOs\OrganisationData;

class UpdateOrganisation
{
    public function __construct(protected OrganisationRepository $repo) {}

    public function execute(OrganisationData $data, Organisation $model): Organisation
    {
        return $this->repo->update($model, $data);
    }
}