<?php

namespace App\Domains\Forms\Repositories;

use App\Domains\Forms\Models\VirtualForm;

class VirtualFormRepository
{
    public function create(array $data): VirtualForm
    {
        return VirtualForm::create($data);
    }

    public function update(VirtualForm $model, array $data): VirtualForm
    {
        $model->update($data);
        return $model;
    }

    public function find(int $id): ?VirtualForm
    {
        return VirtualForm::find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return VirtualForm::paginate($perPage);
    }
}