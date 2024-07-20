<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Component extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vendor_code',
        'amount',
        'node_id',
        'unit_id',
    ];

    public function node(): BelongsTo
    {
        return $this->belongsTo(Node::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function alertCharacteristics(): HasOne
    {
        return $this->hasOne(AlertCharacteristics::class);
    }

    public function serviceCharacteristics(): HasOne
    {
        return $this->hasOne(ServiceCharacteristics::class);
    }

    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class);
    }
}
