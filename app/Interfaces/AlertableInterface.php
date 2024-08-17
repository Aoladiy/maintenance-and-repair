<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property non-negative-int $alert_in_advance_in_hours
 * @property non-negative-int $alert_in_advance_in_engine_hours
 * @property non-negative-int $alert_in_advance_in_mileage
 * @property boolean $alert
 */
interface AlertableInterface
{
    /**
     * @return MorphOne
     */
    public function alertCharacteristics(): MorphOne;

    /**
     * @return int|null
     */
    public function getAlertInAdvanceInHoursAttribute(): ?int;

    /**
     * @return int|null
     */
    public function getAlertInAdvanceInEngineHoursAttribute(): ?int;

    /**
     * @return int|null
     */
    public function getAlertInAdvanceInMileageAttribute(): ?int;

    /**
     * @return int|null
     */
    public function getAlertAttribute(): ?int;
}
