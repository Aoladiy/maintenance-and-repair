<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Maintenance;
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
            'item_id' => $request->item_id,
            'username' => $request->username,
            'datetime_of_service' => $request->datetime_of_service,
        ];
        $item = Item::findOrFail($data['item_id']);
        if (is_null($item->datetime_of_next_service)) {
            $data['deadline_date'] = null;
        } else {
            $data['deadline_date'] = date("Y-m-d", strtotime($item->datetime_of_next_service));
        }

        if ($item->datetime_of_last_service > $data['datetime_of_service']) {
            return response()->json(['datetime_of_service' => 'Дата технического обслуживания не должна быть меньше предыдущей даты технического обслуживания'], 422);
        }

        $item->datetime_of_last_service = $data['datetime_of_service'];
        $item->save();
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
