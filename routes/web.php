<?php

use App\Http\Controllers\AlertCharacteristicsController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\NodeController;
use App\Http\Controllers\ScheduledMaintenanceController;
use App\Http\Controllers\ScheduledPurchaseController;
use App\Http\Controllers\ServiceCharacteristicsController;
use App\Http\Controllers\SiteController;
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

Route::get('/', [BasicController::class, 'index'])->name('index');

Route::post('/alert-characteristics/edit', [AlertCharacteristicsController::class, 'getAlertableById'])->name('alert-characteristics.byId');
Route::patch('/alert-characteristics/update', [AlertCharacteristicsController::class, 'updateAlertable'])->name('alert-characteristics.update');

Route::post('/service-characteristics/edit', [ServiceCharacteristicsController::class, 'getServiceableById'])->name('service-characteristics.byId');
Route::patch('/service-characteristics/update', [ServiceCharacteristicsController::class, 'updateServiceable'])->name('service-characteristics.update');

Route::get('/sites', [BasicController::class, 'sites'])->name('sites');
Route::get('/sites/all', [SiteController::class, 'index'])->name('sites.all');
Route::get('/sites/{id}', [SiteController::class, 'show'])->name('sites.show');
Route::post('/sites/store', [SiteController::class, 'store'])->name('sites.store');
Route::patch('/sites/{id}/update', [SiteController::class, 'update'])->name('sites.update');
Route::delete('/sites/{id}/delete', [SiteController::class, 'destroy'])->name('sites.delete');

Route::get('/equipment/site/{id}', [BasicController::class, 'equipment'])->name('equipment.bySite');
Route::get('/equipment/site/{id}/all', [EquipmentController::class, 'getEquipmentBySiteId'])->name('equipment.bySite.all');
Route::get('/equipment/{id}', [EquipmentController::class, 'show'])->name('equipment.show');
Route::post('/equipment/store', [EquipmentController::class, 'store'])->name('equipment.store');
Route::patch('/equipment/{id}/update', [EquipmentController::class, 'update'])->name('equipment.update');
Route::delete('/equipment/{id}/delete', [EquipmentController::class, 'destroy'])->name('equipment.delete');

Route::get('/nodes/equipment/{id}', [BasicController::class, 'nodes'])->name('nodes.byEquipment');
Route::get('/nodes/equipment/{id}/all', [NodeController::class, 'getNodeByEquipmentId'])->name('nodes.byEquipment.all');
Route::get('/nodes/{id}', [NodeController::class, 'show'])->name('nodes.show');
Route::post('/nodes/store', [NodeController::class, 'store'])->name('nodes.store');
Route::patch('/nodes/{id}/update', [NodeController::class, 'update'])->name('nodes.update');
Route::delete('/nodes/{id}/delete', [NodeController::class, 'destroy'])->name('nodes.delete');

Route::get('/components/node/{id}', [BasicController::class, 'components'])->name('components.byNode');
Route::get('/components/node/{id}/all', [ComponentController::class, 'getComponentByNodeId'])->name('components.byNode.all');
Route::get('/components/{id}', [ComponentController::class, 'show'])->name('components.show');
Route::post('/components/store', [ComponentController::class, 'store'])->name('components.store');
Route::patch('/components/{id}/update', [ComponentController::class, 'update'])->name('components.update');
Route::delete('/components/{id}/delete', [ComponentController::class, 'destroy'])->name('components.delete');


Route::get('/old', [ItemController::class, 'index'])->name('old.index');
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
