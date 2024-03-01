<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'site',
        'equipment_name',
        'inventory_number',
        'node',
        'component',
        'vendor_code',
        'operation',
        'service_period_in_days',
        'service_period_in_engine_hours',
        'mileage',
        'amount',
        'parent_id',
    ];

    public function children()
    {
        return $this->hasMany(Item::class, 'parent_id');
    }
}
