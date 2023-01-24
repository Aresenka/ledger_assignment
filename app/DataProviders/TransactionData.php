<?php

namespace App\DataProviders;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class TransactionData implements Arrayable
{
    public const TYPE_OUT = "Outcome";
    public const TYPE_IN = "Income";

    public string $txId;
    public string $idempotencyKey;
    public string $type;
    public string $status;
    public int $amount;
    public int $currencyId;
    public string $createdAt;
    public ?int $sender = null;
    public ?int $receiver = null;

    public function __construct(Transaction $transaction, int $accountId) {
        if ($transaction->from_account_id == $accountId) {
            $this->type = self::TYPE_OUT;
            $this->receiver = $transaction->to_account_id;
        } else {
            $this->type = self::TYPE_IN;
            $this->sender = $transaction->from_account_id;
        }

        $this->status = $transaction->status;
        $this->txId = $transaction->getAttributes()['id'];
        $this->idempotencyKey = $transaction->idempotency_key;
        $this->currencyId = $transaction->currency_id;
        $this->createdAt = Carbon::parse($transaction->created_at)->format("Y/m/d H:i:s");
        $this->amount = $transaction->amount;
    }

    public function toArray(): array
    {
        $result = [
            "tx_id" => $this->txId,
            "idempotency_key" => $this->idempotencyKey,
            "status" => $this->status,
            "type" => $this->type,
            "sender_id" => $this->sender,
            "receiver_id" => $this->receiver,
            "currency_id" => $this->currencyId,
            "amount" => $this->amount,
            "created_at" => $this->createdAt,
        ];

        if ($this->sender) {
            unset($result["receiver_id"]);
        } else {
            unset($result["sender_id"]);
        }

        return $result;
    }
}