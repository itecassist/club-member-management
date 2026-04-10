<?php

namespace App\Domains\Tenancy\Actions;

use App\Domains\Tenancy\Repositories\OrganisationRepository;
use App\Domains\Tenancy\Models\Organisation;

class DeleteOrganisation
{
    public function __construct(protected OrganisationRepository $repo) {}

    public function execute(Organisation $model): void
    {
        $this->repo->delete($model);
    }
}