<?php

namespace Database\Factories;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Balance>
 */
class BalanceFactory extends Factory
{
    private const DEFAULT_ACCOUNT_ID = 1;
    private const DEFAULT_CURRENCY_ID = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'account_id' => self::DEFAULT_ACCOUNT_ID,
            'currency_id' => self::DEFAULT_CURRENCY_ID,
            'amount' => random_int(0, 10_000_000_000),
            'created_at' => Carbon::now(),
        ];
    }
}
