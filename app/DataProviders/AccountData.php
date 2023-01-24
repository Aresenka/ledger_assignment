<?php

namespace App\DataProviders;

use App\Models\Account;
use Illuminate\Contracts\Support\Arrayable;

class AccountData implements Arrayable
{
    public string $id;
    /** @var array<string, array>  */
    public $balances;

    public function __construct(Account $account) {
        $this->id = $account->uuid;

        foreach ($account->balance as $balance) {
            $currency = $balance->currency;
            $amount = $balance->amount / $currency->units_amount;

            $this->balances[$currency->ticker] = [
                "name" => $currency->name,
                "amount_in_tokens" => $amount,
                "amount_in_units" => $balance->amount,
            ];
        }
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "available_balance" => $this->balances,
        ];
    }
}