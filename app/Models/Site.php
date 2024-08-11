<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @return HasMany
     */
    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    /**
     * @return bool
     */
    public function hasEquipment(): bool
    {
        return $this->equipments()->exists();
    }
}
