<?php

namespace App\Http\Controllers;

use App\Models\Node;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class NodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Node::all()->each(function ($site) {
            $site->has_components = $site->hasComponents();
        });
    }

    public function getNodeByEquipmentId(int $id): Collection
    {
        return Node::query()
            ->where('equipment_id', $id)
            ->get()
            ->each(function ($site) {
                $site->has_components = $site->hasComponents();
            });
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
        $equipment = Node::query()->create($request->all());
        $equipment->has_components = $equipment->hasComponents();
        return $equipment;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Node::query()->findOrFail($id);
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
        $equipment = Node::query()->findOrFail($id);
        $equipment->update($request->all());
        $equipment->has_components = $equipment->hasComponents();
        return $equipment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Node::query()->findOrFail($id)->delete();
    }
}
