<?php

namespace App\Domains\Forms\Actions;

use App\Domains\Forms\Repositories\VirtualFormRepository;
use App\Domains\Forms\Models\VirtualForm;

class DeleteVirtualForm
{
    public function __construct(protected VirtualFormRepository $repo) {}

    public function execute(VirtualForm $model): void
    {
        $this->repo->delete($model);
    }
}