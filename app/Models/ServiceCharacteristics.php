<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceCharacteristics extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_duration_in_seconds',
        'service_period_in_days',
        'service_period_in_engine_hours',
        'engine_hours_by_the_datetime_of_last_service',
        'mileage',
        'mileage_by_the_datetime_of_last_service',
        'datetime_of_last_service',
        'datetime_of_next_service',
        'component_id',
    ];

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }
}
