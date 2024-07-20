<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlertCharacteristics extends Model
{
    use HasFactory;

    protected $fillable = [
        'alert_in_advance_in_hours',
        'alert_in_advance_in_engine_hours',
        'alert_in_advance_in_mileage',
        'alert',
        'component_id',
    ];

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }
}
