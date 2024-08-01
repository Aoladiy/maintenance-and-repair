<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Component::all()
            ->each(function ($component) {
//            $component->has_components = $component->hasComponents();
                $component->unit = $component->unit()->first()->name;
            });
    }

    public function getComponentByNodeId(int $id): Collection
    {
        return Component::query()
            ->where('node_id', $id)
            ->get()
            ->each(function ($component) {
//                $component->has_components = $component->hasComponents();
                $component->unit = $component->unit()->first()->name;
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
        $component = Component::query()->create($request->all());
//        $component->has_components = $component->hasComponents();
        $component->unit = $component->unit()->first()->name;
        return $component;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Component::query()->findOrFail($id);
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
        $component = Component::query()->findOrFail($id);
        $component->update($request->all());
//        $component->has_components = $component->hasComponents();
        $component->unit = $component->unit()->first()->name;
        return $component;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Component::query()->findOrFail($id)->delete();
    }
}
