<?php
namespace App\Http\Controllers\Auth;

use App\Domains\Auth\Repositories\PermissionRepository;
use App\Domains\Auth\Actions\CreatePermission;
use App\Domains\Auth\Actions\UpdatePermission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController {
    public function __construct(
        protected PermissionRepository $repo,
        protected CreatePermission $create,
        protected UpdatePermission $update
    ) {}
    public function index()
    {
        return response()->json($this->repo->paginate());
    }
    public function store(StorePermissionRequest $r) {
        return $this->create->execute($r->validated());
    }

    public function update(UpdatePermissionRequest $r, $id) {
        return $this->update->execute($r->validated(), $this->repo->find($id));
    }
}