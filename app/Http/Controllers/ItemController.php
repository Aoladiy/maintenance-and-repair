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
    public function items(): view
    {
        $items = Item::query()->where('parent_id', null)->get();
        $items->each(function ($child) {
            $child->has_children = $child->hasChildren();
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
            'service_period_in_days' => $item->service_period_in_days,
            'service_period_in_engine_hours' => $item->service_period_in_engine_hours,
            'mileage' => $item->mileage,
            'amount' => $item->amount,
            'has_children' => $item->hasChildren(),
        ]);
    }

    public function children(int $id): Collection
    {
        if ($id == -1) {
            $items = Item::query()->where('parent_id', null)->get();
            $items->each(function ($child) {
                $child->has_children = $child->hasChildren();
            });
            return $items;
        } else {
            $children = Item::query()->find($id)->children()->get();
            $children->each(function ($child) {
                $child->has_children = $child->hasChildren();
            });
            return $children;
        }
    }

    public function create(Request $request): Item
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
                'service_period_in_days',
                'service_period_in_engine_hours',
                'mileage',
                'amount',
                'parent_id',
            ]
        );
        return Item::create($data);
    }

    public function update(Request $request, int $id): Item
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
                'service_period_in_days',
                'service_period_in_engine_hours',
                'mileage',
                'amount',
                'parent_id',
            ]
        );

        $item = Item::findOrFail($id);

        $item->update($data);
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
