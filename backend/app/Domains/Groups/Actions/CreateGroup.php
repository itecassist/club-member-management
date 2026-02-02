<?php
namespace App\Domains\Groups\Actions;
use App\Domains\Groups\Repositories\GroupRepository;
use App\Domains\Groups\Models\Group;

class CreateGroup {
    public function __construct(protected GroupRepository $repo) {}
    public function execute(array $data, Group $model = null): Group {
        $model = $this->repo->create($data);
        return $model;
    }
}