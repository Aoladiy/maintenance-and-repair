<?php

namespace App\Http\Controllers;

use App\Models\ScheduledPurchase;
use App\Models\ServiceCharacteristics;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduledPurchaseController extends Controller
{
    public function index(): View
    {
        $scheduledPurchases = ServiceCharacteristics::query()
            ->whereNotNull('datetime_of_next_service')
            ->get();
        return view('scheduled-purchases', ['scheduledPurchases' => $scheduledPurchases]);
    }
}
