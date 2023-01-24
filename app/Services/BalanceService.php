<?php

namespace App\Services;

use App\Models\Balance;
use App\Repositories\BalanceRepository;

class BalanceService
{
    private BalanceRepository $repository;

    public function __construct(BalanceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function balanceHasAmount(int $accountId, int $currencyId, int $amount): bool
    {
        $balance = $this->repository->getBalanceOrCreateEmpty($accountId, $currencyId);

        return $balance->amount >= $amount;
    }

    public function addAmountToBalance(Balance $balance, int $amount): void
    {
        $balance->amount += $amount;

        $balance->save();
    }
}