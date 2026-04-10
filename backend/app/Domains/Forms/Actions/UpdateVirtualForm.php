<?php

namespace App\Domains\Forms\Actions;

use App\Domains\Forms\Repositories\VirtualFormRepository;
use App\Domains\Forms\Models\VirtualForm;
use App\Domains\Forms\DTOs\VirtualFormData;

class UpdateVirtualForm
{
    public function __construct(protected VirtualFormRepository $repo) {}

    public function execute(VirtualFormData $data, VirtualForm $model): VirtualForm
    {
        return $this->repo->update($model, $data);
    }
}