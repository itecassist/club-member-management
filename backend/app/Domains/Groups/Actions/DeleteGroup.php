<?php

namespace App\Domains\Groups\Actions;

use App\Domains\Groups\Repositories\GroupRepository;
use App\Domains\Groups\Models\Group;

class DeleteGroup
{
    public function __construct(protected GroupRepository $repo) {}

    public function execute(Group $model): void
    {
        $this->repo->delete($model);
    }
}