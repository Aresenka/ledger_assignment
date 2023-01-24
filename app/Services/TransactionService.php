<?php

namespace App\Services;

use App\DataProviders\TransactionData;
use App\Exceptions\TransactionException;
use App\Http\Requests\NewTransactionRequest;
use App\Models\Transaction;
use App\Repositories\BalanceRepository;
use App\Repositories\TransactionRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    private TransactionRepository $transactionRepository;
    private BalanceService $balanceService;
    private BalanceRepository $balanceRepository;

    public function __construct(
        TransactionRepository $transactionRepository,
        BalanceService        $balanceService,
        BalanceRepository     $balanceRepository
    )
    {
        $this->transactionRepository = $transactionRepository;
        $this->balanceService = $balanceService;
        $this->balanceRepository = $balanceRepository;
    }

    /**
     * @throws TransactionException
     */
    public function handleTransaction(NewTransactionRequest $request): void
    {
        if (!$this->balanceService->balanceHasAmount($request->transfer_from, $request->currency, $request->amount)) {
            throw new TransactionException("Not enough funds");
        }

        $transaction = $this->createTransactionByRequest($request);

        try {
            DB::beginTransaction();

            $senderBalance = $this->balanceRepository
                ->getBalanceOrCreateEmpty($transaction->from_account_id, $transaction->currency_id);
            $this->balanceService->addAmountToBalance($senderBalance, -$transaction->amount);

            $transaction->status = Transaction::STATUS_SUCCESS;
            $transaction->save();

            $receiverBalance = $this->balanceRepository
                ->getBalanceOrCreateEmpty($transaction->to_account_id, $transaction->currency_id);
            $this->balanceService->addAmountToBalance($receiverBalance, +$transaction->amount);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            $transaction->status = Transaction::STATUS_SUCCESS;
            $transaction->failure_reason = $e->getMessage();
            $transaction->save();

            throw new TransactionException("Something went wrong");
        }
    }

    private function createTransactionByRequest(NewTransactionRequest $request): Transaction
    {
        $transaction = new Transaction();

        $transaction->id = hash('sha256', Carbon::now() . $request->idempotency_key);
        $transaction->idempotency_key = $request->idempotency_key;
        $transaction->from_account_id = $request->transfer_from;
        $transaction->to_account_id = $request->transfer_to;
        $transaction->currency_id = $request->currency;
        $transaction->amount = $request->amount;
        $transaction->status = Transaction::STATUS_PENDING;
        $transaction->created_at = Carbon::now();

        $transaction->save();

        return $transaction;
    }

    public function getListForAccount(int $accountId): array
    {
        $collection = $this->transactionRepository->getAllTransactionsByAccountId($accountId);

        return $collection->map(function (Transaction $tx) use ($accountId) {
            return new TransactionData($tx, $accountId);
        })->toArray();
    }
}