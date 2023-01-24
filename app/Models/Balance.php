<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Attributes
 * @property int id Column to be used in relations
 * @property int account_id Foreign key for Account model
 * @property int currency_id Foreign key for Currency model
 * @property int amount Currency amount in minimal units (satoshi/gwei/etc)
 * @property int created_at
 * @property int|null updated_at
 *
 * Relations
 * @property Account account
 * @property Currency currency
 */
class Balance extends Model
{
    use HasFactory;

    protected $table = 'balance';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_id',
        'currency_id',
        'amount',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
