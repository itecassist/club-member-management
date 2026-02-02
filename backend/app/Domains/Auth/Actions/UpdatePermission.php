<?php
namespace App\Domains\Auth\Actions;
use App\Domains\Auth\Repositories\PermissionRepository;
use App\Domains\Auth\Models\Permission;

class UpdatePermission {
    public function __construct(protected PermissionRepository $repo) {}
    public function execute(array $data, Permission $model = null): Permission {
        $model = $this->repo->update($model, $data);
        return $model;
    }
}