<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 *
 */
class Node extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'equipment_id',
    ];

    /**
     * @return BelongsTo
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    /**
     * @return HasMany
     */
    public function components(): HasMany
    {
        return $this->hasMany(Component::class);
    }

    /**
     * @return bool
     */
    public function hasComponents(): bool
    {
        return $this->components()->exists();
    }

    /**
     * @return MorphOne
     */
    public function alertCharacteristics(): MorphOne
    {
        return $this->morphOne(AlertCharacteristics::class, 'alertable');
    }

    /**
     * @return MorphOne
     */
    public function serviceCharacteristics(): MorphOne
    {
        return $this->morphOne(ServiceCharacteristics::class, 'serviceable');
    }
}
