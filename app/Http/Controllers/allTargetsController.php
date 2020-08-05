<?php

namespace App\Http\Controllers;

use App\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class allTargetsController extends Controller
{
    /**
     * Display all players targets to screen.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $userLoggedIn = Auth::user(); //User logged in
        $playerAccount = $userLoggedIn->player; //Player account of user logged in

        $targetsToReturn = Target::all()->where("player_id", $playerAccount->id); //Targets of player

        return view("allTargets", ["allTargets" => $targetsToReturn]);
    }
}
