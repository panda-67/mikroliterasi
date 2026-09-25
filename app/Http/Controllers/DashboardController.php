<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\ResearchArea;
use App\Models\ResearchProject;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;

class DashboardController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware the controller should use.
     */
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    /**
     * Display the dashboard.
     */
    public function __invoke(): View
    {
        return view('dashboard.index', [
            'researchAreasCount' => ResearchArea::count(),
            'researchProjectsCount' => ResearchProject::count(),
            'publicationsCount' => Publication::count(),
        ]);
    }
}
