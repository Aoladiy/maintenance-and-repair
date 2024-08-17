<?php

namespace App\Traits;

/**
 * @property string $class_name
 */
trait ClassNameDataTrait
{
    /**
     * @return void
     */
    public function initializeClassNameDataTrait(): void
    {
        $this->append([
            'class_name',
        ]);
    }

    /**
     * @return string
     */
    public function getClassNameAttribute(): string
    {
        return get_class($this);
    }
}
