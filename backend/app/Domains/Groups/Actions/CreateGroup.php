<?php

namespace App\Domains\Groups\Actions;

use App\Domains\Groups\Repositories\GroupRepository;
use App\Domains\Groups\Models\Group;
use App\Domains\Groups\DTOs\GroupData;
use App\Domains\Groups\Events\GroupCreated;

class CreateGroup
{
    public function __construct(protected GroupRepository $repo) {}

    public function execute(GroupData $data): Group
    {
        $model = $this->repo->create($data);
        event(new GroupCreated($model->id, $model->organisation_id));
        return $model;
    }
}