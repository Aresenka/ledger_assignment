<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository
{
    private Account $model;

    public function __construct(Account $model)
    {
        $this->model = $model;
    }

    public function findAccountById(int $accountId): ?Account
    {
        /** @var Account|null */
        return $this->model->newQuery()
            ->find($accountId);
    }
}