<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class ScheduledPurchase extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'component',
        'unit_id',
        'number',
    ];

    /**
     * @return BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
