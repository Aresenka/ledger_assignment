<?php

namespace Tests\Unit;

use App\Models\Balance;
use App\Repositories\BalanceRepository;
use App\Services\BalanceService;
use PHPUnit\Framework\TestCase;

class BalanceServiceTest extends TestCase
{
    public function test_balance_has_amount_positive()
    {
        $accountId = 1;
        $currencyId = 1;
        $balance = new Balance(['amount' => 1000]);
        $amount = 500;

        $repository = $this->createMock(BalanceRepository::class);
        $repository->expects($this->once())
            ->method('getBalanceOrCreateEmpty')
            ->with($accountId, $currencyId)
            ->willReturn($balance);

        $service = new BalanceService($repository);
        $this->assertTrue($service->balanceHasAmount($accountId, $currencyId, $amount));
    }

    public function test_balance_has_amount_negative_not_enough_funds()
    {
        $accountId = 1;
        $currencyId = 1;
        $balance = new Balance(['amount' => 100]);
        $amount = 500;

        $repository = $this->createMock(BalanceRepository::class);
        $repository->expects($this->once())
            ->method('getBalanceOrCreateEmpty')
            ->with($accountId, $currencyId)
            ->willReturn($balance);

        $service = new BalanceService($repository);
        $this->assertFalse($service->balanceHasAmount($accountId, $currencyId, $amount));
    }

    public function test_balance_has_amount_negative_new_balance()
    {
        $accountId = 1;
        $currencyId = 1;
        $amount = 500;

        $repository = $this->createMock(BalanceRepository::class);
        $repository->expects($this->once())
            ->method('getBalanceOrCreateEmpty')
            ->with($accountId, $currencyId);

        $service = new BalanceService($repository);
        $this->assertFalse($service->balanceHasAmount($accountId, $currencyId, $amount));
    }
}
