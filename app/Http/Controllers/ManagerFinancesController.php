<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerFinancesController extends Controller
{
    /**
     * Generate managerFinances view to screen with relevant variables
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $user = Auth::user(); //Currently logged in user
        $teamToReturn = $user->manager->team; //Team of currently logged in user

        return view("managerFinances", ["team" => $teamToReturn]);
    }

    /**
     * Edit Subscription fee value for team of interest
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit(Request $request) {
        $user = Auth::user(); //Currently logged in user
        $teamToReturn = $user->manager->team; //Team of logged in user

        //Update subscription value of Team model
        $teamToReturn->subscription = request("feeAmount");
        $teamToReturn->save();

        return redirect(route("managerFinances"));

    }


}
