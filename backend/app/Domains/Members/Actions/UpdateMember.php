<?php

namespace App\Domains\Members\Actions;

use App\Domains\Members\DTOs\MemberData;
use App\Domains\Members\Models\Member;
use App\Domains\Members\Repositories\MemberRepository;

class UpdateMember
{
    public function __construct(protected MemberRepository $repo) {}

    public function execute(MemberData $data, Member $model): Member
    {
        return $this->repo->update($model, $data);
    }
}
