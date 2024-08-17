<?php

namespace App\Traits;

trait ServiceCharacteristicsDataTrait
{
    public function initializeServiceCharacteristicsDataTrait(): void
    {
        $this->append([
            'service_duration_in_seconds',
            'service_period_in_days',
            'service_period_in_engine_hours',
            'engine_hours_by_the_datetime_of_last_service',
            'mileage',
            'mileage_by_the_datetime_of_last_service',
            'datetime_of_last_service',
            'datetime_of_next_service',
        ]);
    }

    public function getServiceDurationInSecondsAttribute(): ?int
    {
        return $this->serviceCharacteristics()->first()?->service_duration_in_seconds;
    }

    public function getServicePeriodInDaysAttribute(): ?int
    {
        return $this->serviceCharacteristics()->first()?->service_period_in_days;
    }

    public function getServicePeriodInEngineHoursAttribute(): ?int
    {
        return $this->serviceCharacteristics()->first()?->service_period_in_engine_hours;
    }

    public function getEngineHoursByTheDatetimeOfLastServiceAttribute(): ?int
    {
        return $this->serviceCharacteristics()->first()?->engine_hours_by_the_datetime_of_last_service;
    }

    public function getMileageAttribute(): ?int
    {
        return $this->serviceCharacteristics()->first()?->mileage;
    }

    public function getMileageByTheDatetimeOfLastServiceAttribute(): ?int
    {
        return $this->serviceCharacteristics()->first()?->mileage_by_the_datetime_of_last_service;
    }

    public function getDateTimeOfLastServiceAttribute(): ?string
    {
        return $this->serviceCharacteristics()->first()?->datetime_of_last_service;
    }

    public function getDateTimeOfNextServiceAttribute(): ?string
    {
        return $this->serviceCharacteristics()->first()?->datetime_of_next_service;
    }
}
