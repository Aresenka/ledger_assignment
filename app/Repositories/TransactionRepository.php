<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository
{
    private Transaction $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    public function getAllTransactionsByAccountId(int $accountId): Collection
    {
        /** @var Collection<?Transaction> */
        return $this->model->newQuery()
            ->where('from_account_id', $accountId)
            ->orWhere('to_account_id', $accountId)
            ->get();
    }
}