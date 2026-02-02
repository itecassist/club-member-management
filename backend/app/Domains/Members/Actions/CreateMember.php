<?php
namespace App\Domains\Members\Actions;
use App\Domains\Members\Repositories\MemberRepository;
use App\Domains\Members\Models\Member;

class CreateMember {
    public function __construct(protected MemberRepository $repo) {}
    public function execute(array $data, Member $model = null): Member {
        $model = $this->repo->create($data);
        return $model;
    }
}