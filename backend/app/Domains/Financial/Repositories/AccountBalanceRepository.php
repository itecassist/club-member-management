<?php

namespace App\Domains\Financial\Repositories;

use App\Domains\Financial\Models\AccountBalance;

class AccountBalanceRepository
{
    public function create(array $data): AccountBalance
    {
        return AccountBalance::create($data);
    }

    public function update(AccountBalance $model, array $data): AccountBalance
    {
        $model->update($data);
        return $model;
    }

    public function find(int $id): ?AccountBalance
    {
        return AccountBalance::find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return AccountBalance::paginate($perPage);
    }
}