<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ScheduledMaintenanceController;
use App\Http\Controllers\ScheduledPurchaseController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ItemController::class, 'index'])->name('index');
Route::get('items', [ItemController::class, 'items'])->name('items');
Route::get('items/{id}', [ItemController::class, 'item'])->name('item');
Route::get('items/{id}/children', [ItemController::class, 'children'])->name('children');
Route::post('items/create', [ItemController::class, 'create'])->name('create');
Route::patch('items/{id}/update', [ItemController::class, 'update'])->name('update');
Route::delete('items/{id}/delete', [ItemController::class, 'delete'])->name('delete');

Route::get('items/{id}/alerts', [ItemController::class, 'alerts'])->name('alerts');

Route::get('maintenance/time', [MaintenanceController::class, 'time'])->name('maintenance.time');
Route::post('maintenance/create', [MaintenanceController::class, 'store'])->name('maintenance.store');

Route::get('units', [UnitController::class, 'units'])->name('units');

Route::get('scheduled-maintenances', [ScheduledMaintenanceController::class, 'index'])->name('scheduled-maintenances.index');
Route::get('scheduled-purchases', [ScheduledPurchaseController::class, 'index'])->name('scheduled-purchases.index');
