<?php

namespace App\Domains\Members\Repositories;

use App\Domains\Members\DTOs\MemberData;
use App\Domains\Members\Models\Member;

class MemberRepository
{
    public function create(MemberData $data): Member
    {
        return Member::create($data->toArray());
    }

    public function update(Member $model, MemberData $data): Member
    {
        $model->update($data->toArray());
        return $model;
    }

    public function find(int $id): ?Member
    {
        return Member::find($id);
    }

    public function findOrFail(int $id): Member
    {
        return Member::findOrFail($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Member::paginate($perPage);
    }

    public function delete(Member $model): void
    {
        $model->delete();
    }
}
