<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Repositories\RoleRepository;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\DTOs\RoleData;

class UpdateRole
{
    public function __construct(protected RoleRepository $repo) {}

    public function execute(RoleData $data, Role $model): Role
    {
        return $this->repo->update($model, $data);
    }
}