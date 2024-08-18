<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class Site extends Model
{
    use HasFactory;

    /**
     * @var bool|mixed
     */
    public bool $hasEquipment;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'all_alerts_number',
    ];

    /**
     * @return HasMany
     */
    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    /**
     * @return bool
     */
    public function hasEquipment(): bool
    {
        return $this->equipment()->exists();
    }

    /**
     * @return int
     */
    public function getAllAlertsNumberAttribute(): int
    {
        return DB::table('equipment')
            ->join('nodes', 'equipment.id', '=', 'nodes.equipment_id')
            ->join('alert_characteristics', 'nodes.id', '=', 'alert_characteristics.alertable_id')
            ->where('alert_characteristics.alertable_type', Node::class)
            ->where('equipment.site_id', $this->id)
            ->sum('alert_characteristics.alert');
    }
}
