<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property non-negative-int $service_duration_in_seconds
 * @property int $service_period_in_days
 * @property non-negative-int $service_period_in_engine_hours
 * @property non-negative-int $engine_hours_by_the_datetime_of_last_service
 * @property non-negative-int $mileage
 * @property non-negative-int $mileage_by_the_datetime_of_last_service
 * @property string $datetime_of_last_service
 * @property string $datetime_of_next_service
 */
interface ServiceableInterface
{
    /**
     * @return MorphOne
     */
    public function serviceCharacteristics(): MorphOne;

    /**
     * @return int|null
     */
    public function getServiceDurationInSecondsAttribute(): ?int;

    /**
     * @return int|null
     */
    public function getServicePeriodInDaysAttribute(): ?int;

    /**
     * @return int|null
     */
    public function getServicePeriodInEngineHoursAttribute(): ?int;

    /**
     * @return int|null
     */
    public function getEngineHoursByTheDatetimeOfLastServiceAttribute(): ?int;

    /**
     * @return int|null
     */
    public function getServicePeriodInMileageAttribute(): ?int;

    /**
     * @return int|null
     */
    public function getMileageByTheDatetimeOfLastServiceAttribute(): ?int;

    /**
     * @return string|null
     */
    public function getDateTimeOfLastServiceAttribute(): ?string;

    /**
     * @return string|null
     */
    public function getDateTimeOfNextServiceAttribute(): ?string;
}
