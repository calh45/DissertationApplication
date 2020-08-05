<?php

namespace App\Http\Controllers;

use App\Availability;
use App\CalendarEvent;
use App\Event;
use App\Manager;
use App\Player;
use App\Target;
use App\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Array_;

class ManagerSideController extends Controller
{
    /**
     * Displayers manager home screen hub
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        //Retrieves User logged in and Manager account
        $userLoggedIn = Auth::user();
        $currentLoggedIn = Manager::all()->where("userId", $userLoggedIn->id)->first();

        $team = Team::all()->where("managerId", $currentLoggedIn->id)->first(); //Team of logged in account
        $players = $team->players; //Players from logged in account team
        $behindFees = Player::all()->where("balance", "<", 0); //Players behind on fees

        //Retrieve Calendar events in future
        $events = CalendarEvent::orderBy("task_date")->where("team_id", $userLoggedIn->manager->team->teamId)->
            where("task_date", ">=", Carbon::now())->get();

        //Retrieve availability notifications
        $availabilities = Availability::orderBy("created_at", "desc")->where("team_id", $userLoggedIn->manager->team->teamId)->get();

        //Retrieve top performing players from squad
        $topPerformers = $this->getTopPerformers($players, $currentLoggedIn);

        //Retrieve targets of players from team
        $targets = $this->getTargets($team->teamId);

        return view("managerHome")->with(["currentLoggedIn" => $currentLoggedIn, "team" => $team, "players" => $players,
            "events" => $events, "behindFees" => $behindFees, "availabilities" => $availabilities, "topPerformers" => $topPerformers,
            "targets" => $targets]);
    }

    /**
     * Function to retrieve top performing players for the relevant team
     * @param $players
     * @param $currentLoggedIn
     * @return mixed
     */
    public function getTopPerformers($players, $currentLoggedIn) {
        $toReturn = Player::orderBy("totalScore", "desc")->where("teamId", $currentLoggedIn->team->teamId)->get();

        return $toReturn;

    }

    /**
     * Function to get all targets attributed to players from team
     * @param $teamId
     * @return array
     */
    public function getTargets($teamId) {
        $toReturn = [];

        $targets = Target::all();

        foreach($targets as $target) {
            $playerToCheck = Player::find($target->player_id);
            if($playerToCheck->team->teamId == $teamId) {
                array_push($toReturn, $target);
            }
        }

        return $toReturn;
    }
}
