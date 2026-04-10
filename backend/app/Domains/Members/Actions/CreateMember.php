<?php

namespace App\Domains\Members\Actions;

use App\Domains\Members\DTOs\MemberData;
use App\Domains\Members\Events\MemberCreated;
use App\Domains\Members\Models\Member;
use App\Domains\Members\Repositories\MemberRepository;

class CreateMember
{
    public function __construct(protected MemberRepository $repo) {}

    public function execute(MemberData $data): Member
    {
        $model = $this->repo->create($data);
        event(new MemberCreated($model->id, $model->organisation_id));
        return $model;
    }
}
