<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function dashboardStatistics(Request $request){

        $userId = Auth::id();

        
        return $this->apiResponse(true, 'Dashboard Statistics', [
            'user' => $request->user()
        ]);
    }
}
