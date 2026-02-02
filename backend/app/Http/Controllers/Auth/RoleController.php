<?php
namespace App\Http\Controllers\Auth;

use App\Domains\Auth\Repositories\RoleRepository;
use App\Domains\Auth\Actions\CreateRole;
use App\Domains\Auth\Actions\UpdateRole;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController {
    public function __construct(
        protected RoleRepository $repo,
        protected CreateRole $create,
        protected UpdateRole $update
    ) {}
    public function index()
    {
        return response()->json($this->repo->paginate());
    }
    public function store(StoreRoleRequest $r) {
        return $this->create->execute($r->validated());
    }

    public function update(UpdateRoleRequest $r, $id) {
        return $this->update->execute($r->validated(), $this->repo->find($id));
    }
}