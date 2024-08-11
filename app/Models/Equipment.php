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
class Equipment extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'inventory_number',
        'site_id',
    ];

    /**
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * @return HasMany
     */
    public function nodes(): HasMany
    {
        return $this->hasMany(Node::class);
    }

    /**
     * @return bool
     */
    public function hasNodes(): bool
    {
        return $this->nodes()->exists();
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
