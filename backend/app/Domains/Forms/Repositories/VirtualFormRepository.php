<?php

namespace App\Domains\Forms\Repositories;

use App\Domains\Forms\Models\VirtualForm;
use App\Domains\Forms\DTOs\VirtualFormData;

class VirtualFormRepository
{
    public function create(VirtualFormData $data): VirtualForm
    {
        return VirtualForm::create($data->toArray());
    }

    public function update(VirtualForm $model, VirtualFormData $data): VirtualForm
    {
        $model->update($data->toArray());
        return $model;
    }

    public function find(int $id): ?VirtualForm
    {
        return VirtualForm::find($id);
    }

    public function findOrFail(int $id): VirtualForm
    {
        return VirtualForm::findOrFail($id);
    }

    public function paginate(int $perPage = 15)
    {
        return VirtualForm::paginate($perPage);
    }

    public function delete(VirtualForm $model): void
    {
        $model->delete();
    }
}