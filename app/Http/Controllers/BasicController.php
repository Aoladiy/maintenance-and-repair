<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BasicController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect(route('sites'));
    }

    public function sites(): View
    {
        return view('site.index');
    }

    public function equipment(int $id): View
    {
        $site = Site::query()->findOrFail($id);
        return view('equipment.index', ['site' => $site, 'parentId' => $site->id]);
    }
}
