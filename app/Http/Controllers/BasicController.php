<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Node;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class BasicController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        return redirect(route('sites'));
    }

    /**
     * @return View
     */
    public function sites(): View
    {
        return view('site.index');
    }

    /**
     * @param int $id
     * @return View
     */
    public function equipment(int $id): View
    {
        $site = Site::query()->findOrFail($id);
        return view('equipment.index', ['site' => $site, 'parentId' => $site->id]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function nodes(int $id): View
    {
        $equipment = Equipment::query()->findOrFail($id);
        $site = $equipment->site;
        return view('node.index', ['site' => $site, 'equipment' => $equipment, 'parentId' => $equipment->id]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function components(int $id): View
    {
        $node = Node::query()->findOrFail($id);
        $equipment = $node->equipment;
        $site = $equipment->site;
        return view('component.index', ['site' => $site, 'equipment' => $equipment, 'node' => $node, 'parentId' => $node->id]);
    }
}
