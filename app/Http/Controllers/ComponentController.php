<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 *
 */
class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Component::all();
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getComponentByNodeId(int $id): Collection
    {
        return Component::query()
            ->where('node_id', $id)
            ->get();
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
    public function store(Request $request): Component
    {
        /** @var Component $component */
        $component = Component::query()->create($request->all());
        return $component;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Component
    {
        /** @var Component $component */
        $component = Component::query()->findOrFail($id);
        return $component;
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
    public function update(Request $request, string $id): Component
    {
        /** @var Component $component */
        $component = Component::query()->findOrFail($id);
        $component->update($request->all());
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
