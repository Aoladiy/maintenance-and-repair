<?php

use App\Http\Controllers\ItemController;
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

Route::get('items', [ItemController::class, 'items'])->name('items');
Route::get('items/{id}', [ItemController::class, 'item'])->name('item');
Route::get('items/{id}/children', [ItemController::class, 'children'])->name('children');
Route::post('items/create', [ItemController::class, 'create'])->name('create');
Route::patch('items/{id}/update', [ItemController::class, 'update'])->name('update');
Route::delete('items/{id}/delete', [ItemController::class, 'delete'])->name('delete');
