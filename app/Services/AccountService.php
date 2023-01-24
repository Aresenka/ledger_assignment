<?php

namespace App\Services;

use App\DataProviders\AccountData;
use App\Exceptions\ModelNotFound;
use App\Repositories\AccountRepository;

class AccountService
{
    private AccountRepository $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws ModelNotFound
     */
    public function getAccountData(int $accountId): AccountData
    {
        $account = $this->repository->findAccountById($accountId);

        if (!$account) {
            throw new ModelNotFound("Account with such id does not exist");
        }

        return new AccountData($account);
    }

}