<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class Unit extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * @return HasMany
     */
    public function scheduledPurchases(): HasMany
    {
        return $this->hasMany(ScheduledPurchase::class);
    }

    /**
     * @return HasMany
     */
    public function components(): HasMany
    {
        return $this->hasMany(Component::class);
    }
}
