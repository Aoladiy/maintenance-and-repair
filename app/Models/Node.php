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
class Node extends Model implements ServiceableInterface, AlertableInterface
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
        'equipment_id',
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
        return DB::table('alert_characteristics')
                ->where('alertable_type', Component::class)
                ->join('components', 'alert_characteristics.alertable_id', '=', 'components.id')
                ->where('components.node_id', $this->id)
                ->sum('alert_characteristics.alert') + $this->alerts_number;
    }
}
