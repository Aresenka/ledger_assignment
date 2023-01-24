<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Attributes
 * @property int id Column to be used in relations
 * @property string uuid Unique id string
 * @property int created_at
 * @property int|null updated_at
 *
 * Relations
 * @property Balance[] balance
 */
class Account extends Model
{
    use HasFactory;

    public const UUID_SIZE = 10;

    protected $table = 'account';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
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

    public function balance(): HasMany
    {
        return $this->hasMany(Balance::class);
    }
}
