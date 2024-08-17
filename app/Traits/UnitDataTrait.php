<?php

namespace App\Traits;

/**
 * @property string $unit
 */
trait UnitDataTrait
{
    /**
     * @return void
     */
    public function initializeUnitDataTrait(): void
    {
        $this->append([
            'unit',
        ]);
    }

    /**
     * @return string|null
     */
    public function getUnitAttribute(): ?string
    {
        return $this->unit()->first()?->name;
    }
}
