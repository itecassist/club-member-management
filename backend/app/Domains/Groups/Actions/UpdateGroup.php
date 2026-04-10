<?php

namespace App\Domains\Groups\Actions;

use App\Domains\Groups\Repositories\GroupRepository;
use App\Domains\Groups\Models\Group;
use App\Domains\Groups\DTOs\GroupData;

class UpdateGroup
{
    public function __construct(protected GroupRepository $repo) {}

    public function execute(GroupData $data, Group $model): Group
    {
        return $this->repo->update($model, $data);
    }
}