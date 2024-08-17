<?php

namespace App\Traits;

trait AlertCharacteristicsDataTrait
{
    public function initializeAlertCharacteristicsDataTrait(): void
    {
        $this->append([
            'alert_in_advance_in_hours',
            'alert_in_advance_in_engine_hours',
            'alert_in_advance_in_mileage',
            'alert'
        ]);
    }

    public function getAlertInAdvanceInHoursAttribute(): ?int
    {
        return $this->alertCharacteristics()->first()?->alert_in_advance_in_hours;
    }

    public function getAlertInAdvanceInEngineHoursAttribute(): ?int
    {
        return $this->alertCharacteristics()->first()?->alert_in_advance_in_engine_hours;
    }

    public function getAlertInAdvanceInMileageAttribute(): ?int
    {
        return $this->alertCharacteristics()->first()?->alert_in_advance_in_mileage;
    }

    public function getAlertAttribute(): ?int
    {
        return $this->alertCharacteristics()->first()?->alert;
    }
}
