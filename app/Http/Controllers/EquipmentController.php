<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Equipment::all()->each(function ($site) {
            $site->has_nodes = $site->hasNodes();
        });
    }

    public function getEquipmentBySiteId(int $id): Collection
    {
        return Equipment::query()->where('site_id', $id)->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $equipment = Equipment::query()->create($request->all());
        $equipment->has_nodes = $equipment->hasNodes();
        return $equipment;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Equipment::query()->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $equipment = Equipment::query()->findOrFail($id);
        $equipment->update($request->all());
        $equipment->has_nodes = $equipment->hasNodes();
        return $equipment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Equipment::query()->findOrFail($id)->delete();
    }
}
