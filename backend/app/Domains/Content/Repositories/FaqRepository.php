<?php

namespace App\Domains\Content\Repositories;

use App\Domains\Content\Models\Faq;
use App\Domains\Content\DTOs\FaqData;

class FaqRepository
{
    public function create(FaqData $data): Faq
    {
        return Faq::create($data->toArray());
    }

    public function update(Faq $model, FaqData $data): Faq
    {
        $model->update($data->toArray());
        return $model;
    }

    public function find(int $id): ?Faq
    {
        return Faq::find($id);
    }

    public function findOrFail(int $id): Faq
    {
        return Faq::findOrFail($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Faq::paginate($perPage);
    }

    public function delete(Faq $model): void
    {
        $model->delete();
    }
}