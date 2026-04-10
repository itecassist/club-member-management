<?php

namespace App\Domains\Financial\Repositories;

use App\Domains\Financial\Models\AccountBalance;
use App\Domains\Financial\DTOs\AccountBalanceData;

class AccountBalanceRepository
{
    public function create(AccountBalanceData $data): AccountBalance
    {
        return AccountBalance::create($data->toArray());
    }

    public function update(AccountBalance $model, AccountBalanceData $data): AccountBalance
    {
        $model->update($data->toArray());
        return $model;
    }

    public function find(int $id): ?AccountBalance
    {
        return AccountBalance::find($id);
    }

    public function findOrFail(int $id): AccountBalance
    {
        return AccountBalance::findOrFail($id);
    }

    public function paginate(int $perPage = 15)
    {
        return AccountBalance::paginate($perPage);
    }

    public function delete(AccountBalance $model): void
    {
        $model->delete();
    }
}