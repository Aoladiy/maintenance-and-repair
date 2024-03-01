<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function items(): view
    {
        $items = Item::get();
        return view('items.tree', ['items' => $items]);
    }

    public function children(int $id): Collection
    {
        return Item::find($id)->children()->get();
    }
}
