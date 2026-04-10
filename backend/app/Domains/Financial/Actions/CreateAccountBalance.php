<?php

namespace App\Domains\Financial\Actions;

use App\Domains\Financial\Repositories\AccountBalanceRepository;
use App\Domains\Financial\Models\AccountBalance;
use App\Domains\Financial\DTOs\AccountBalanceData;
use App\Domains\Financial\Events\AccountBalanceCreated;

class CreateAccountBalance
{
    public function __construct(protected AccountBalanceRepository $repo) {}

    public function execute(AccountBalanceData $data): AccountBalance
    {
        $model = $this->repo->create($data);
        event(new AccountBalanceCreated($model->id, $model->organisation_id));
        return $model;
    }
}