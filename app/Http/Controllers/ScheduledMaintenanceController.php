<?php

namespace App\Http\Controllers;

use App\Models\ScheduledMaintenance;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduledMaintenanceController extends Controller
{
    public function index(): View
    {
        $scheduledMaintenances = ScheduledMaintenance::all();
        return view('scheduled-maintenances', ['scheduledMaintenances' => $scheduledMaintenances]);
    }
}
