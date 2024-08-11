<?php

namespace App\Http\Controllers;

use App\Models\AlertCharacteristics;
use App\Models\Component;
use App\Models\ServiceCharacteristics;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function attachAdditionalData(Component $component): Component
    {
        $unit = $component->unit()->first();
        /** @var ServiceCharacteristics $serviceCharacteristics */
        $serviceCharacteristics = $component->serviceCharacteristics()->first();
        /** @var AlertCharacteristics $alertCharacteristics */
        $alertCharacteristics = $component->alertCharacteristics()->first();

        $component->unit = $unit?->name;

        $component->service_duration_in_seconds = $serviceCharacteristics?->service_duration_in_seconds;
        $component->service_period_in_days = $serviceCharacteristics?->service_period_in_days;
        $component->service_period_in_engine_hours = $serviceCharacteristics?->service_period_in_engine_hours;
        $component->engine_hours_by_the_datetime_of_last_service = $serviceCharacteristics?->engine_hours_by_the_datetime_of_last_service;
        $component->mileage = $serviceCharacteristics?->mileage;
        $component->mileage_by_the_datetime_of_last_service = $serviceCharacteristics?->mileage_by_the_datetime_of_last_service;
        $component->datetime_of_last_service = $serviceCharacteristics?->datetime_of_last_service;
        $component->datetime_of_next_service = $serviceCharacteristics?->datetime_of_next_service;

        $component->alert_in_advance_in_hours = $alertCharacteristics?->alert_in_advance_in_hours;
        $component->alert_in_advance_in_engine_hours = $alertCharacteristics?->alert_in_advance_in_engine_hours;
        $component->alert_in_advance_in_mileage = $alertCharacteristics?->alert_in_advance_in_mileage;
        $component->alert = $alertCharacteristics?->alert;
        return $component;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Component::all()
            ->each([$this, 'attachAdditionalData']);
    }

    public function getComponentByNodeId(int $id): Collection
    {
        return Component::query()
            ->where('node_id', $id)
            ->get()
            ->each([$this, 'attachAdditionalData']);
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
        $component = $this->attachAdditionalData($component);
        $this->attachAdditionalData($component);
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
        $this->attachAdditionalData($component);
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
