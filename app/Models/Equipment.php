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
use Illuminate\Support\Facades\DB;

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
        'all_alerts_number',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'alerts_number',
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
    public function allAlertsNumber(): int
    {
        $alertsFromComponents = $this->nodes->sum(function($node) {
            return $node->allAlertsNumber();
        });

        return $this->alerts_number + $alertsFromComponents;
    }

    /**
     * @return BelongsTo
     */
    public function parentAlertable(): BelongsTo
    {
        return $this->site();
    }

    /**
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return sprintf(route('equipment.bySite', $this->site->id) . '?name=%s&inventory_number=%s', $this->name, $this->inventory_number);
    }
}
