<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function units(): JsonResponse
    {
        $units = Unit::all();
        return response()->json($units);
    }
}
