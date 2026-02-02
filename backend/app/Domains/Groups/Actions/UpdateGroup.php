<?php
namespace App\Domains\Groups\Actions;
use App\Domains\Groups\Repositories\GroupRepository;
use App\Domains\Groups\Models\Group;

class UpdateGroup {
    public function __construct(protected GroupRepository $repo) {}
    public function execute(array $data, Group $model = null): Group {
        $model = $this->repo->update($model, $data);
        return $model;
    }
}