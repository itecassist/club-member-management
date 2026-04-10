<?php

namespace App\Domains\Members\Actions;

use App\Domains\Members\Models\Member;
use App\Domains\Members\Repositories\MemberRepository;

class DeleteMember
{
    public function __construct(protected MemberRepository $repo) {}

    public function execute(Member $model): void
    {
        $this->repo->delete($model);
    }
}
