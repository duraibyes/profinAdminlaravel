<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\DashboardRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $dashboardRepository;
    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->middleware('auth');
        $this->dashboardRepository    = $dashboardRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $params = array();        
        return view('platform.dashboard.home', $params);
    }
 
}
