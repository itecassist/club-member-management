<?php

namespace App\Domains\Financial\Actions;

use App\Domains\Financial\Repositories\AccountBalanceRepository;
use App\Domains\Financial\Models\AccountBalance;

class DeleteAccountBalance
{
    public function __construct(protected AccountBalanceRepository $repo) {}

    public function execute(AccountBalance $model): void
    {
        $this->repo->delete($model);
    }
}