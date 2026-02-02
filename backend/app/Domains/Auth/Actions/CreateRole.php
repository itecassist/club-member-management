<?php
namespace App\Domains\Auth\Actions;
use App\Domains\Auth\Repositories\RoleRepository;
use App\Domains\Auth\Models\Role;

class CreateRole {
    public function __construct(protected RoleRepository $repo) {}
    public function execute(array $data, Role $model = null): Role {
        $model = $this->repo->create($data);
        return $model;
    }
}