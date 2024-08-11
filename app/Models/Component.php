<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $unit
 * @property non-negative-int $service_duration_in_seconds
 * @property int $service_period_in_days
 * @property non-negative-int $service_period_in_engine_hours
 * @property non-negative-int $engine_hours_by_the_datetime_of_last_service
 * @property non-negative-int $mileage
 * @property non-negative-int $mileage_by_the_datetime_of_last_service
 * @property string $datetime_of_last_service
 * @property string $datetime_of_next_service
 * @property non-negative-int $alert_in_advance_in_hours
 * @property non-negative-int $alert_in_advance_in_engine_hours
 * @property non-negative-int $alert_in_advance_in_mileage
 * @property boolean $alert
 */
class Component extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vendor_code',
        'amount',
        'node_id',
        'unit_id',
    ];

    public function node(): BelongsTo
    {
        return $this->belongsTo(Node::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function alertCharacteristics(): HasOne
    {
        return $this->hasOne(AlertCharacteristics::class);
    }

    public function serviceCharacteristics(): HasOne
    {
        return $this->hasOne(ServiceCharacteristics::class);
    }

    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class);
    }
}
