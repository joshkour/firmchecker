<?php

namespace App\Controllers;

use Auth;
use App\Facades\DashboardFacade;

/**
 * DashboardController class.
 *
 * @author Josh Kour <josh.kour@gmail.com>
 */
class DashboardController extends BaseController {
	private $dashboardFacade;

    /**
     * Class constructor.
     *
     * @param DashboardFacade $dashboardFacade
     * @return void
     */
	public function __construct(DashboardFacade $dashboardFacade)
    {   
        $this->dashboardFacade = $dashboardFacade;
    }

    /**
     * Index method.
     *
     * @param void
     * @return void
     */
    public function index()
    {
        // Check if current logged in user has permission to access this page
        // If not, return with unauthorised (HTTP response with unauthorised)
        $user = Auth::user();
        if (!$user->hasPermission(PERMISSION_VIEW_DASHBOARD_INDEX)) {
            return $this->redirectUnauthorised();
        }

        // Facade is used to hide complexities and to ensure cleaner and maintainable code
        $dashboardMetrics = $this->dashboardFacade->getDashboardMetrics();

        // Pass data and display in the view
    	return $this->view('dashboard_metrics', compact('dashboardMetrics'));
    }
}