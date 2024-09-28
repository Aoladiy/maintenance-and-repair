<?php

namespace App\Http\Controllers;

use App\Events\AlertChangedEvent;
use App\Models\AlertCharacteristics;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 *
 */
class AlertCharacteristicsController extends Controller
{
    /**
     * @param Request $request
     * @return Model
     */
    public function getAlertableById(Request $request): Model
    {
        return AlertCharacteristics::query()
            ->where('alertable_id', $request->get('alertable_id'))
            ->where('alertable_type', $request->get('alertable_type'))
            ->firstOrNew();
    }

    /**
     * @param Request $request
     * @return Model
     */
    public function updateAlertable(Request $request): Model
    {
        $data = $request->all();
        if (isset($data['alert'])) {
            $data['alert'] = 1;
        } else {
            $data['alert'] = 0;
        }

        $alertCharacteristics = AlertCharacteristics::query()->updateOrCreate(
            [
                'alertable_id' => $data['alertable_id'],
                'alertable_type' => $data['alertable_type'],
            ],
            $data
        );
        $alertCharacteristics->all_alerts_number = $alertCharacteristics->alertable()->first()->all_alerts_number;

        AlertChangedEvent::dispatch($alertCharacteristics->alertable()->first());

        return $alertCharacteristics;
    }
}
