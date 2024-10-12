<?php

namespace App\Http\Controllers;

use App\Models\ScheduledMaintenance;
use App\Models\ServiceCharacteristics;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduledMaintenanceController extends Controller
{
    public function index(): View
    {
        $serviceCharacteristics = ServiceCharacteristics::query()
            ->whereNotNull('datetime_of_next_service')
            ->get();
        return view('scheduled-maintenances', ['serviceCharacteristics' => $serviceCharacteristics]);
    }
}
