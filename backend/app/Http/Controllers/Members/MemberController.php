<?php
namespace App\Http\Controllers\Members;

use App\Domains\Members\Repositories\MemberRepository;
use App\Domains\Members\Actions\CreateMember;
use App\Domains\Members\Actions\UpdateMember;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;

class MemberController {
    public function __construct(
        protected MemberRepository $repo,
        protected CreateMember $create,
        protected UpdateMember $update
    ) {}
    public function index()
    {
        return response()->json($this->repo->paginate());
    }
    public function store(StoreMemberRequest $r) {
        return $this->create->execute($r->validated());
    }

    public function update(UpdateMemberRequest $r, $id) {
        return $this->update->execute($r->validated(), $this->repo->find($id));
    }
}