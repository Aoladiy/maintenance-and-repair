<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

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
        'all_alerts_number',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
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
    public function allAlertsNumber(): int
    {
        $alertsFromComponents = $this->equipment->sum(function($equipment) {
            return $equipment->allAlertsNumber();
        });

        return $this->alerts_number + $alertsFromComponents;
    }

    //TODO что я понял - нужно чтобы при любом изменении alert срабатывал event, который запустит job, которая рекурсивно обсчитает all_alerts_number (новый столбец в alert_characteristics) пока нашел 2 места куда влепить event: AlertCharacteristicsController и getCurrentEngineHoursAndMileAge
}
