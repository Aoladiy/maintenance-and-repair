<?php

namespace App\Http\Controllers;

use App\Models\ServiceCharacteristics;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 *
 */
class ServiceCharacteristicsController extends Controller
{
    /**
     * @param Request $request
     * @return Model
     */
    public function getServiceableById(Request $request): Model
    {
        return ServiceCharacteristics::query()
            ->where('serviceable_id', $request->get('serviceable_id'))
            ->where('serviceable_type', $request->get('serviceable_type'))
            ->firstOrNew();
    }

    /**
     * @param Request $request
     * @return Model
     */
    public function updateServiceable(Request $request): Model
    {
        $data = $request->all();

        return ServiceCharacteristics::query()->updateOrCreate(
            [
                'serviceable_id' => $data['serviceable_id'],
                'serviceable_type' => $data['serviceable_type'],
            ],
            $data
        );
    }
}
