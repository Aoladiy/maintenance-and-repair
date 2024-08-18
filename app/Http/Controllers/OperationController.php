<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Http\JsonResponse;

class OperationController extends Controller
{
    public function operations(): JsonResponse
    {
        $units = Operation::all();
        return response()->json($units);
    }
}
