<?php

namespace App\Repositories;

use App\Models\Balance;

class BalanceRepository
{
    private Balance $model;

    public function __construct(Balance $model)
    {
        $this->model = $model;
    }

    public function findBalanceByAccountAndCurrency(int $accountId, int $currencyId): ?Balance
    {
        /** @var Balance|null */
        return $this->model->newQuery()
            ->where([
                ["account_id", "=", $accountId],
                ["currency_id", "=", $currencyId],
            ])
            ->first();
    }


    public function getBalanceOrCreateEmpty(int $accountId, int $currencyId): Balance
    {
        $balance = $this->findBalanceByAccountAndCurrency($accountId, $currencyId);

        if (!$balance) {
            $balance = $this->createEmptyBalance($accountId, $currencyId);
        }

        return $balance;
    }

    public function createEmptyBalance(int $accountId, int $currencyId): Balance
    {
        /** @var Balance */
        return $this->model->newQuery()->create([
            "account_id" => $accountId,
            "currency_id" => $currencyId,
            "amount" => 0
        ]);
    }
}