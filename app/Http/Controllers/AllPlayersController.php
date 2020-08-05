<?php

namespace App\Http\Controllers;

use App\Player;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllPlayersController extends Controller
{
    /**
     * Displays view with statistics of whole squad to screen
     * @param $toOrder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($toOrder) {

        $loggedIn = Auth::user(); //Logged in user (Manager or Player)

        //Retrieve team depending on account type logged in
        if($loggedIn->accountType == "M") {
            $team = Team::all()->where("managerId", Auth::user()->manager->id)->first();

        } else {
            $team = $loggedIn->player->team;
        }

        $players = Player::orderBy($toOrder, "desc")->where("teamId", $team->teamId)->get(); //Players from team
        $columnsLabels = ["appearances", "goals", "assists", "yellowCards", "redCards", "fouls", "totalScore"]; //Stats labels
        return view("allPlayers", ["columns" => $columnsLabels, "players" => $players, "columnLabels" => $columnsLabels]);
    }
}
