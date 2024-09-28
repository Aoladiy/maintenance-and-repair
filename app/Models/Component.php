<?php

namespace App\Models;

use App\Interfaces\AlertableInterface;
use App\Interfaces\ServiceableInterface;
use App\Traits\AlertCharacteristicsDataTrait;
use App\Traits\ClassNameDataTrait;
use App\Traits\ServiceCharacteristicsDataTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 *
 */
class Component extends Model implements ServiceableInterface, AlertableInterface
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
        'vendor_code',
        'amount',
        'node_id',
        'unit_id',
        'all_alerts_number',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'unit',
        'operations',
        'alerts_number',
    ];

    /**
     * @return BelongsTo
     */
    public function node(): BelongsTo
    {
        return $this->belongsTo(Node::class);
    }

    /**
     * @return BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
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
     * @return BelongsToMany
     */
    public function operations(): BelongsToMany
    {
        return $this->belongsToMany(Operation::class, 'component_operation_pivot');
    }

    /**
     * @return string|null
     */
    public function getUnitAttribute(): ?string
    {
        return $this->unit()->first()?->name;
    }

    /**
     * @return Collection
     */
    public function getOperationsAttribute(): Collection
    {
        return $this->operations()->get();
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
        return $this->alerts_number;
    }

    /**
     * @return BelongsTo
     */
    public function parentAlertable(): BelongsTo
    {
        return $this->node();
    }
}
