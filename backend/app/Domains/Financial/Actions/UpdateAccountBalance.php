<?php

namespace App\Domains\Financial\Actions;

use App\Domains\Financial\Repositories\AccountBalanceRepository;
use App\Domains\Financial\Models\AccountBalance;
use App\Domains\Financial\DTOs\AccountBalanceData;

class UpdateAccountBalance
{
    public function __construct(protected AccountBalanceRepository $repo) {}

    public function execute(AccountBalanceData $data, AccountBalance $model): AccountBalance
    {
        return $this->repo->update($model, $data);
    }
}