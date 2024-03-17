<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'engine_hours_on_the_datetime_of_last_service',
        'mileage',
        'mileage_on_the_datetime_of_last_service',
        'amount',
        'datetime_of_last_service',
        'parent_id',
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Item::class, 'parent_id');
    }

    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    public function ancestors()
    {
        $ancestors = [];
        $currentItem = $this;

        while ($currentItem->parent_id !== null) {
            $parentItem = Item::find($currentItem->parent_id);
            if ($parentItem) {
                $ancestors[] = $parentItem;
                $currentItem = $parentItem;
            } else {
                // If parent item is not found, exit the loop
                break;
            }
        }

        return array_reverse($ancestors);
    }

    public function alerts()
    {
        $totalAlerts = 0;

        // Проверяем, есть ли у текущего элемента уведомление
        if ($this->alert) {
            $totalAlerts++;
        }

        // Получаем всех дочерних элементов
        $children = $this->children;

        // Рекурсивно вызываем alerts() для каждого дочернего элемента
        foreach ($children as $child) {
            $totalAlerts += $child->alerts();
        }

        return $totalAlerts;
    }

}
