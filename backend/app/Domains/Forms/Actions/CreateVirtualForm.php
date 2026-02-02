<?php
namespace App\Domains\Forms\Actions;
use App\Domains\Forms\Repositories\VirtualFormRepository;
use App\Domains\Forms\Models\VirtualForm;

class CreateVirtualForm {
    public function __construct(protected VirtualFormRepository $repo) {}
    public function execute(array $data, VirtualForm $model = null): VirtualForm {
        $model = $this->repo->create($data);
        return $model;
    }
}