<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Attributes
 * @property int id Column to be used in relations
 * @property string name Human-readable currency name (Etherium/Bitcoin/etc)
 * @property string ticker Exchanges ticker for the currency (ETH/BTC/etc)
 * @property int units_amount Minimal units amount (gwei/satoshi/etc) in one token
 * @property int created_at
 * @property int|null updated_at
 */
class Currency extends Model
{
    use HasFactory;

    protected $table = 'currency';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'ticker',
        'units_amount',
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
}
