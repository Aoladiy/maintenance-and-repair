<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class Site extends Model
{
    use HasFactory;

    /**
     * @var bool|mixed
     */
    public bool $hasEquipment;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'all_alerts_number',
    ];

    /**
     * @return HasMany
     */
    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    /**
     * @return bool
     */
    public function hasEquipment(): bool
    {
        return $this->equipment()->exists();
    }

    /**
     * @return int
     */
    public function getAllAlertsNumberAttribute(): int
    {
        return $this->equipment->sum(function (Equipment $equipment) {
            return $equipment->all_alerts_number;
        });
    }
}
