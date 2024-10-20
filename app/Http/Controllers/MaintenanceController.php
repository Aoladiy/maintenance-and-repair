<?php

namespace App\Http\Controllers;

use App\Events\AlertChangedEvent;
use App\Events\AlertPossibleChangeEvent;
use App\Events\FillDatetimeOfNextServiceEvent;
use App\Models\Maintenance;
use App\Models\ServiceCharacteristics;
use DateTime;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function time()
    {
        return response()->json([
            'datetime_of_service' => (new DateTime())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'comment' => $request->comment,
            'serviceable_id' => $request->serviceable_id,
            'serviceable_type' => $request->serviceable_type,
            'username' => $request->username,
            'datetime_of_service' => $request->datetime_of_service,
        ];
        $serviceCharacteristicsQuery = ServiceCharacteristics::query()->where([
            'serviceable_id' => $data['serviceable_id'],
            'serviceable_type' => $data['serviceable_type'],]);
        if ($serviceCharacteristicsQuery->exists()) {
            /** @var ServiceCharacteristics $serviceCharacteristicsIdInput */
            $serviceCharacteristicsIdInput = $serviceCharacteristicsQuery->first();
        } else {
            $serviceCharacteristicsIdInput = new ServiceCharacteristics();
            $serviceCharacteristicsIdInput->serviceable_id = $data['serviceable_id'];
            $serviceCharacteristicsIdInput->serviceable_type = $data['serviceable_type'];
        }
        if (is_null($serviceCharacteristicsIdInput->datetime_of_next_service)) {
            $data['deadline_date'] = null;
        } else {
            $data['deadline_date'] = date("Y-m-d", strtotime($serviceCharacteristicsIdInput->datetime_of_next_service));
        }

        if ($serviceCharacteristicsIdInput->datetime_of_last_service > $data['datetime_of_service']) {
            return response()->json(['datetime_of_service' => 'Дата технического обслуживания не должна быть меньше предыдущей даты технического обслуживания'], 422);
        }

        $serviceCharacteristicsIdInput->datetime_of_last_service = $data['datetime_of_service'];
        $serviceCharacteristicsIdInput->save();
        $data['service_characteristics_id'] = $serviceCharacteristicsIdInput->id;
        AlertPossibleChangeEvent::dispatch();
        FillDatetimeOfNextServiceEvent::dispatch();
        return Maintenance::query()->create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenance $maintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        //
    }
}
