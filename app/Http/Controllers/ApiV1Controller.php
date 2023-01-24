<?php

namespace App\Http\Controllers;

use App\DataProviders\AccountData;
use App\DataProviders\TransactionData;
use App\Exceptions\ModelNotFound;
use App\Exceptions\TransactionException;
use App\Http\Requests\NewTransactionRequest;
use App\Http\Responses\BasicResponse;
use App\Services\AccountService;
use App\Services\TransactionService;
use Illuminate\Routing\Controller as BaseController;

class ApiV1Controller extends BaseController
{
    private AccountService $accountService;
    private TransactionService $transactionService;

    public function __construct(
        AccountService     $accountService,
        TransactionService $transactionService
    )
    {
        $this->accountService = $accountService;
        $this->transactionService = $transactionService;
    }

    /** @return AccountData|array<string,mixed> */
    public function getAccountInfo(int $accountId): AccountData|array
    {
        try {
            return $this->accountService->getAccountData($accountId);
        } catch (ModelNotFound $e) {
            return BasicResponse::parseThrowableToError($e);
        }
    }

    /** @return array<string,mixed> */
    public function initTransaction(NewTransactionRequest $request): array
    {
        try {
            $this->transactionService->handleTransaction($request);

            return BasicResponse::makeSuccess("Transaction created.");
        } catch (TransactionException $e) {
            return BasicResponse::parseThrowableToError($e);
        }
    }

    /**
     * @param int $accountId
     * @return array<TransactionData>
     */
    public function getAccountTransactions(int $accountId): array
    {
        return $this->transactionService->getListForAccount($accountId);
    }
}
