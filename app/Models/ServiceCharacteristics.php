<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property non-negative-int $service_duration_in_seconds
 * @property int $service_period_in_days
 * @property non-negative-int $service_period_in_engine_hours
 * @property non-negative-int $engine_hours_by_the_datetime_of_last_service
 * @property non-negative-int $current_engine_hours
 * @property non-negative-int $service_period_in_mileage
 * @property non-negative-int $mileage_by_the_datetime_of_last_service
 * @property non-negative-int $current_mileage
 * @property string $datetime_of_last_service
 * @property string $datetime_of_next_service
 */
class ServiceCharacteristics extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'service_duration_in_seconds',
        'service_period_in_days',
        'service_period_in_engine_hours',
        'engine_hours_by_the_datetime_of_last_service',
        'current_engine_hours',
        'service_period_in_mileage',
        'mileage_by_the_datetime_of_last_service',
        'current_mileage',
        'datetime_of_last_service',
        'datetime_of_next_service',
        'serviceable_id',
        'serviceable_type',
    ];

    /**
     * @return MorphTo
     */
    public function serviceable(): MorphTo
    {
        return $this->morphTo();
    }
}
