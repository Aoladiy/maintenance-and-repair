<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiteStoreRequest;
use App\Http\Requests\SiteUpdateRequest;
use App\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Site::all()->each(function ($site) {
            $site->has_equipment = $site->hasEquipment();
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SiteStoreRequest $request)
    {
        $site = Site::query()->create($request->all());
        $site->has_equipment = $site->hasEquipment();
        return $site;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Site::query()->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SiteUpdateRequest $request, string $id)
    {
        $site = Site::query()->findOrFail($id);
        $site->update($request->all());
        $site->has_equipment = $site->hasEquipment();
        return $site;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Site::query()->findOrFail($id)->delete();
    }
}
