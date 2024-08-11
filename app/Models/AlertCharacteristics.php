<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property non-negative-int $alert_in_advance_in_hours
 * @property non-negative-int $alert_in_advance_in_engine_hours
 * @property non-negative-int $alert_in_advance_in_mileage
 * @property boolean $alert
 */
class AlertCharacteristics extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'alert_in_advance_in_hours',
        'alert_in_advance_in_engine_hours',
        'alert_in_advance_in_mileage',
        'alert',
        'alertable_id',
        'alertable_type',
    ];

    /**
     * @return MorphTo
     */
    public function alertable(): MorphTo
    {
        return $this->morphTo();
    }
}
