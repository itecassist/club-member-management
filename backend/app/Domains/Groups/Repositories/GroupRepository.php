<?php

namespace App\Domains\Groups\Repositories;

use App\Domains\Groups\Models\Group;

class GroupRepository
{
    public function create(array $data): Group
    {
        return Group::create($data);
    }

    public function update(Group $model, array $data): Group
    {
        $model->update($data);
        return $model;
    }

    public function find(int $id): ?Group
    {
        return Group::find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Group::paginate($perPage);
    }
}