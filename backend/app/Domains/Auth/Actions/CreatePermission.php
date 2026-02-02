<?php
namespace App\Domains\Auth\Actions;
use App\Domains\Auth\Repositories\PermissionRepository;
use App\Domains\Auth\Models\Permission;

class CreatePermission {
    public function __construct(protected PermissionRepository $repo) {}
    public function execute(array $data, Permission $model = null): Permission {
        $model = $this->repo->create($data);
        return $model;
    }
}