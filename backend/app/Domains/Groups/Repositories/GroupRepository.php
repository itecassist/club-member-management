<?php

namespace App\Domains\Groups\Repositories;

use App\Domains\Groups\Models\Group;
use App\Domains\Groups\DTOs\GroupData;

class GroupRepository
{
    public function create(GroupData $data): Group
    {
        return Group::create($data->toArray());
    }

    public function update(Group $model, GroupData $data): Group
    {
        $model->update($data->toArray());
        return $model;
    }

    public function find(int $id): ?Group
    {
        return Group::find($id);
    }

    public function findOrFail(int $id): Group
    {
        return Group::findOrFail($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Group::paginate($perPage);
    }

    public function delete(Group $model): void
    {
        $model->delete();
    }
}