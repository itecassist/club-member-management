<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Repositories\RoleRepository;
use App\Domains\Auth\Models\Role;

class DeleteRole
{
    public function __construct(protected RoleRepository $repo) {}

    public function execute(Role $model): void
    {
        $this->repo->delete($model);
    }
}