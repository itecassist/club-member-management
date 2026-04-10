<?php

namespace App\Domains\Forms\Actions;

use App\Domains\Forms\Repositories\VirtualFormRepository;
use App\Domains\Forms\Models\VirtualForm;
use App\Domains\Forms\DTOs\VirtualFormData;
use App\Domains\Forms\Events\VirtualFormCreated;

class CreateVirtualForm
{
    public function __construct(protected VirtualFormRepository $repo) {}

    public function execute(VirtualFormData $data): VirtualForm
    {
        $model = $this->repo->create($data);
        event(new VirtualFormCreated($model->id, $model->organisation_id));
        return $model;
    }
}