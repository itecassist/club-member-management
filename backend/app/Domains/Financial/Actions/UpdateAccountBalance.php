<?php
namespace App\Domains\Financial\Actions;
use App\Domains\Financial\Repositories\AccountBalanceRepository;
use App\Domains\Financial\Models\AccountBalance;

class UpdateAccountBalance {
    public function __construct(protected AccountBalanceRepository $repo) {}
    public function execute(array $data, AccountBalance $model = null): AccountBalance {
        $model = $this->repo->update($model, $data);
        return $model;
    }
}