<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private DashboardService $dashboardService)
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['member'] = $this->dashboardService->countMember();
        $data['contribution'] = $this->dashboardService->countContribution();
        $data['sanction'] = $this->dashboardService->countSanction();
        $data['association'] = $this->dashboardService->countAssociation();
        $data['loan'] = $this->dashboardService->countLoan();
        $data['fund'] = $this->dashboardService->countFund();
        $data['meeting'] = $this->dashboardService->countMeeting();
        $data['session'] = $this->dashboardService->countSession();
        return view('home', compact('data'));
    }
}
