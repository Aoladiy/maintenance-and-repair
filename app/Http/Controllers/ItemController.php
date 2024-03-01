<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function items(): view
    {
        $items = Item::query()->get();
        $items->each(function ($child) {
            $child->has_children = $child->hasChildren();
        });
        return view('items.tree', ['items' => $items]);
    }

    public function children(int $id): Collection
    {
        $children = Item::query()->find($id)->children()->get();
        $children->each(function ($child) {
            $child->has_children = $child->hasChildren();
        });
        return $children;
    }

}
