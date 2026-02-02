<?php

namespace App\Domains\Members\Repositories;

use App\Domains\Members\Models\Member;

class MemberRepository
{
    public function create(array $data): Member
    {
        return Member::create($data);
    }

    public function update(Member $model, array $data): Member
    {
        $model->update($data);
        return $model;
    }

    public function find(int $id): ?Member
    {
        return Member::find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Member::paginate($perPage);
    }
}