<?php

namespace App\Models;

use App\Interfaces\AlertableInterface;
use App\Interfaces\ServiceableInterface;
use App\Traits\AlertCharacteristicsDataTrait;
use App\Traits\ClassNameDataTrait;
use App\Traits\ServiceCharacteristicsDataTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 *
 */
class Equipment extends Model implements ServiceableInterface, AlertableInterface
{
    use HasFactory;
    use ClassNameDataTrait;
    use ServiceCharacteristicsDataTrait;
    use AlertCharacteristicsDataTrait;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'inventory_number',
        'site_id',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'alerts_number',
        'all_alerts_number',
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

    /**
     * @return int
     */
    public function getAlertsNumberAttribute(): int
    {
        return $this->alertCharacteristics?->alert ?? 0;
    }

    /**
     * @return int
     */
    public function getAllAlertsNumberAttribute(): int
    {
        return $this->nodes->sum(function (Node $node) {
                return $node->all_alerts_number;
            }) + $this->alerts_number;
    }
}
