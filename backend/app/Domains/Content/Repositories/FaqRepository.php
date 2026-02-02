<?php

namespace App\Domains\Content\Repositories;

use App\Domains\Content\Models\Faq;

class FaqRepository
{
    public function create(array $data): Faq
    {
        return Faq::create($data);
    }

    public function update(Faq $model, array $data): Faq
    {
        $model->update($data);
        return $model;
    }

    public function find(int $id): ?Faq
    {
        return Faq::find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Faq::paginate($perPage);
    }
}