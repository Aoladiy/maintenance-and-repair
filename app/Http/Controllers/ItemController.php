<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ItemController extends Controller
{

    public function index()
    {
        return view('tree');
    }

    public function alerts(int $id)
    {
        $item = Item::findOrFail($id);
        // Получение JSON массива
        $jsonArray = $item->toJsonArray();

        return json_encode($jsonArray);
    }

    public function items(): view
    {
        $items = Item::query()->where('parent_id', null)->get();
        $items->each(function ($child) {
            $child->has_children = $child->hasChildren();
            $child->ancestors = $child->ancestors();
        });
        return view('items.tree', ['items' => $items]);
    }

    public function item(int $id): JsonResponse
    {
        $item = Item::findOrFail($id);
        return response()->json([
            'equipment_name' => $item->equipment_name,
            'site' => $item->site,
            'inventory_number' => $item->inventory_number,
            'node' => $item->node,
            'component' => $item->component,
            'vendor_code' => $item->vendor_code,
            'operation' => $item->operation,
            'service_duration_in_seconds' => $item->service_duration_in_seconds,
            'service_period_in_days' => $item->service_period_in_days,
            'service_period_in_engine_hours' => $item->service_period_in_engine_hours,
            'engine_hours_on_the_datetime_of_last_service' => $item->engine_hours_on_the_datetime_of_last_service,
            'mileage' => $item->mileage,
            'mileage_on_the_datetime_of_last_service' => $item->mileage_on_the_datetime_of_last_service,
            'amount' => $item->amount,
            'datetime_of_last_service' => $item->datetime_of_last_service,
            'alert_time_in_hours' => $item->alert_time_in_hours,
            'alert_time_in_engine_hours' => $item->alert_time_in_engine_hours,
            'alert_time_in_mileage' => $item->alert_time_in_mileage,
            'alert' => $item->alert,
            'has_children' => $item->hasChildren(),
            'ancestors' => $item->ancestors(),
        ]);
    }

    public function children(int $id): Collection
    {
        if ($id == -1) {
            $items = Item::query()->where('parent_id', null)->get();
            $items->each(function ($child) {
                $child->has_children = $child->hasChildren();
                $child->ancestors = $child->ancestors();
            });
            return $items;
        } else {
            $children = Item::query()->find($id)->children()->get();
            $children->each(function ($child) {
                $child->has_children = $child->hasChildren();
                $child->ancestors = $child->ancestors();
            });
            return $children;
        }
    }

    public function create(Request $request)
    {
        $data = $request->only(
            [
                'site',
                'equipment_name',
                'inventory_number',
                'node',
                'component',
                'vendor_code',
                'operation',
                'service_duration_in_seconds',
                'service_period_in_days',
                'service_period_in_engine_hours',
                'engine_hours_on_the_datetime_of_last_service',
                'mileage',
                'mileage_on_the_datetime_of_last_service',
                'amount',
                'datetime_of_last_service',
                'alert_time_in_hours',
                'alert_time_in_engine_hours',
                'alert_time_in_mileage',
                'alert',
                'parent_id',
            ]
        );
        if ($data['service_duration_in_seconds'] < 1) {
            return response()->json(['service_duration_in_seconds' => 'Длительность проведения технического обслуживания должна быть больше или равна 1'], 422);
        }
        $data['alert'] = isset($data['alert']) ? 1 : 0;
        return Item::create($data);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->only(
            [
                'site',
                'equipment_name',
                'inventory_number',
                'node',
                'component',
                'vendor_code',
                'operation',
                'service_duration_in_seconds',
                'service_period_in_days',
                'service_period_in_engine_hours',
                'engine_hours_on_the_datetime_of_last_service',
                'mileage',
                'mileage_on_the_datetime_of_last_service',
                'amount',
                'datetime_of_last_service',
                'alert_time_in_hours',
                'alert_time_in_engine_hours',
                'alert_time_in_mileage',
                'alert',
                'parent_id',
            ]
        );
        if ($data['service_duration_in_seconds'] < 1) {
            return response()->json(['service_duration_in_seconds' => 'Длительность проведения технического обслуживания должна быть больше или равна 1'], 422);
        }

        $item = Item::findOrFail($id);

        $data['alert'] = isset($data['alert']) ? 1 : 0;

        $item->update($data);
        $item->has_children = $item->hasChildren();
        return $item;
    }

    public function delete(int $id): JsonResponse
    {
        return DB::transaction(function () use ($id) {
            $item = Item::findOrFail($id);

            $items = Item::where('parent_id', $id)->get();
            $parent_id = $item->parent_id;
            foreach ($items as $i) {
                $i->update(['parent_id' => $parent_id]);
            }

            $item->delete();
            return response()->json(['id' => $id, 'parent_id' => $parent_id]);
        });
    }
}
