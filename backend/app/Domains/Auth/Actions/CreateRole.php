<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Repositories\RoleRepository;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\DTOs\RoleData;
use App\Domains\Auth\Events\RoleCreated;

class CreateRole
{
    public function __construct(protected RoleRepository $repo) {}

    public function execute(RoleData $data): Role
    {
        $model = $this->repo->create($data);
        event(new RoleCreated($model->id, $model->organisation_id));
        return $model;
    }
}