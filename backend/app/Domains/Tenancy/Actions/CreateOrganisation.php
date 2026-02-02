<?php
namespace App\Domains\Tenancy\Actions;
use App\Domains\Tenancy\Repositories\OrganisationRepository;
use App\Domains\Tenancy\Models\Organisation;

class CreateOrganisation {
    public function __construct(protected OrganisationRepository $repo) {}
    public function execute(array $data, Organisation $model = null): Organisation {
        $model = $this->repo->create($data);
        return $model;
    }
}