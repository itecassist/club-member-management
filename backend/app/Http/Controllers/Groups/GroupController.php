<?php
namespace App\Http\Controllers\Groups;

use App\Domains\Groups\Repositories\GroupRepository;
use App\Domains\Groups\Actions\CreateGroup;
use App\Domains\Groups\Actions\UpdateGroup;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;

class GroupController {
    public function __construct(
        protected GroupRepository $repo,
        protected CreateGroup $create,
        protected UpdateGroup $update
    ) {}
    public function index()
    {
        return response()->json($this->repo->paginate());
    }
    public function store(StoreGroupRequest $r) {
        return $this->create->execute($r->validated());
    }

    public function update(UpdateGroupRequest $r, $id) {
        return $this->update->execute($r->validated(), $this->repo->find($id));
    }
}