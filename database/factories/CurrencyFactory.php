<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    private const DEFAULT_NAME = 'Bitcoin';
    private const DEFAULT_TICKER = 'BTC';
    private const DEFAULT_MIN_UNITS_AMOUNT = 100_000_000;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => self::DEFAULT_NAME,
            'ticker' => self::DEFAULT_TICKER,
            'units_amount' => self::DEFAULT_MIN_UNITS_AMOUNT,
            'created_at' => Carbon::now(),
        ];
    }
}
