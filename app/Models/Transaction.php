<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Attributes
 * @property string id Column to be used in relations
 * @property string idempotency_key Unique key to make transactions idempotent
 * @property int from_account_id Id of account that sends transaction
 * @property int to_account_id Id of account that receives transaction
 * @property string currency_id Currency used in transaction
 * @property int amount Amount in minimal units of used currency
 * @property string status
 * @property string failure_reason
 * @property int created_at
 * @property int|null updated_at
 *
 * Relations
 * @property Account sender
 * @property Account receiver
 * @property Currency currency
 */
class Transaction extends Model
{
    use HasFactory;

    public const MIN_SEND_AMOUNT = 1_000;
    public const IDEMPOTENCY_KEY_SIZE = 20;
    public const STATUS_PENDING = "pending";
    public const STATUS_SUCCESS = "success";
    public const STATUS_ERROR = "error";

    protected $table = 'transaction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idempotency_key',
        'from_account_id',
        'to_account_id',
        'currency_id',
        'amount',
        'status',
        'failure_reason',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'failed_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function sender(): HasOne
    {
        return $this->hasOne(Account::class, 'id', 'from_account_id');
    }

    public function receiver(): HasOne
    {
        return $this->hasOne(Account::class, 'id', 'to_account_id');
    }

    public function currency(): HasOne
    {
        return $this->hasOne(Currency::class);
    }
}
