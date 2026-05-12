<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function dashboardStatistics(Request $request){

        $userId = Auth::id();

    
        $stats = [ "this_month" => 0,
                    "this_week" => 0, 
                    "budget_left" => 0,
                    "top_category" => 0
                 ];


        
        return $this->apiResponse(true, 'Dashboard Statistics', $stats);
    }
}
