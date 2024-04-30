<?php

namespace App\Http\Controllers;

use App\Models\ScheduledPurchase;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduledPurchaseController extends Controller
{
    public function index(): View
    {
        $scheduledPurchases = ScheduledPurchase::all();
        return view('scheduled-purchases', ['scheduledPurchases' => $scheduledPurchases]);
    }
}
