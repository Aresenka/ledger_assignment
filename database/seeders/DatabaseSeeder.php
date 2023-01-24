<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Balance;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        Account::factory(5)->create();

        Currency::factory()->create();
        Currency::factory()->create([
            'name' => 'Ethereum',
            'ticker' => 'ETH',
            'units_amount' => 100_000_000,
        ]);

        $accounts = Account::all();
        $currencies = Currency::all();

        /** @var Account $account */
        foreach ($accounts as $account) {
            /** @var Currency $currency */
            foreach ($currencies as $currency) {
                Balance::factory()->create([
                    'account_id' => $account->id,
                    'currency_id' => $currency->id,
                ]);
            }
        }
    }
}
