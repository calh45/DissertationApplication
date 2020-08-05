<?php

namespace App\Http\Controllers;

use App\CalendarEvent;
use App\Lineup;
use App\Player;
use Illuminate\Http\Request;

class LineupController extends Controller
{
    /**
     * Displays a Team Lineup creation form to the screen
     * @param $eventId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($eventId) {
        //Retrieve Lineup model if exists
        $lineup = $this->getLineup($eventId);

        //Initialise positions for printing and retrieving functions
        $positionsPrint = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18"];
        $positions = ["one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", "eleven", "twelve",
            "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eighteen"];

        //Retrieve Calendar Event for Lineup of interest
        $event = CalendarEvent::all()->where("id", $eventId)->first();

        //Retrieve Team of Calendar Event
        $team = $event->team->teamId;

        //Retrieve Player Models for each specific player
        $goalkeepers = Player::all()->where("teamId", $team)->where("position", "GK");
        $defenders = Player::all()->where("teamId", $team)->where("position", "DF");
        $midfielders = Player::all()->where("teamId", $team)->where("position", "MF");
        $forwards = Player::all()->where("teamId", $team)->where("position", "FW");

        //Return view
        return view("lineup", ["lineup" => $lineup, "event" => $event, "positions" => $positionsPrint,
            "goalkeepers" => $goalkeepers, "defenders" => $defenders, "midfielders" => $midfielders, "forwards" => $forwards]);

    }

    /**
     * Get Lineup Model for Calendar ID
     * @param $id
     * @return mixed|string
     */
    public function getLineup($id) {
        $returned = Lineup::all()->where("match_id", $id);

        //If model does not exist, return null
        if(count($returned) > 0) {
            return $returned->first();
        } else {
            return "null";
        }
    }


    /**
     * Function to create a Lineup Model
     * @param $eventId
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create($eventId, Request $request) {
        //Get Match Event
        $matchEvent = CalendarEvent::all()->where("id", $eventId)->first();

        //Find if there is an existing lineup for this event, delete it if present
        $existingLineup = $this->getLineup($eventId);
        if($existingLineup != "null") {
            $existingLineup->delete();

        }

        //Generate Array of each position to check for in lineup
        $toCheck = array();
        for ($i = 0; $i < 18; $i++) {
            array_push($toCheck, request(strval($i)));
        }

        //Checks to make sure no Player model has been selected twice, redirects with error if true else creates Lineup
        if($this->doubleCheck($toCheck) === false) {
            //Create Lineup model, checks if Player model exists or position has been set to null
            $newLineup = new Lineup();
            $newLineup->match_id = $eventId;
            $newLineup->formation = request("pictureSelect");
            $newLineup->one = $this->nullDecide(request("1"));
            $newLineup->two = $this->nullDecide(request("2"));
            $newLineup->three = $this->nullDecide(request("3"));
            $newLineup->four = $this->nullDecide(request("4"));
            $newLineup->five = $this->nullDecide(request("5"));
            $newLineup->six = $this->nullDecide(request("6"));
            $newLineup->seven = $this->nullDecide(request("7"));
            $newLineup->eight = $this->nullDecide(request("8"));
            $newLineup->nine = $this->nullDecide(request("9"));
            $newLineup->ten = $this->nullDecide(request("10"));
            $newLineup->eleven = $this->nullDecide(request("11"));
            $newLineup->twelve = $this->nullDecide(request("12"));
            $newLineup->thirteen = $this->nullDecide(request("13"));
            $newLineup->fourteen = $this->nullDecide(request("14"));
            $newLineup->fifteen = $this->nullDecide(request("15"));
            $newLineup->sixteen = $this->nullDecide(request("16"));
            $newLineup->seventeen = $this->nullDecide(request("17"));
            $newLineup->eighteen = $this->nullDecide(request("18"));
            $newLineup->save();

            //Notify Players of Lineup creation
            $playersToNotify = $matchEvent->team->players;
            foreach ($playersToNotify as $thisPlayer) {
                NotificationsController::create($thisPlayer->user->id, "Event",
                    $matchEvent->name." ".$matchEvent->location." has had a lineup uploaded");
            }

            return redirect(route("lineup", ["eventId" => $eventId]));
        } else {
            return redirect(route("lineup", ["eventId" => $eventId]))->
            withErrors(["One player cannot be named in more than one position"]);
        }


    }

    /**
     * Function to check whether a Player model has been selected for a position
     * @param $toCheck
     * @return |null
     */
    public function nullDecide($toCheck) {
        if ($toCheck === "none") {
            return null;
        } else {
            return $toCheck;
        }
    }

    /**
     * Checks whether a Player model has been selected for more than one position.
     * @param $toCheck
     * @return bool
     */
    public function doubleCheck($toCheck) {

        //Loops through each Player model in list and checks it against the remaining models
        for ($i = 0; $i < count($toCheck); $i++) {
            for($m = $i+1; $m < count($toCheck); $m++) {
                //Checks that entries are not equal, the indexes are not equal and neither of the entries are null entries
                if($toCheck[$i] == $toCheck[$m] && ($i != $m) && !($toCheck[$i]=="none") && !($toCheck[$m]=="none")) {
                    return true;
                }
            }
        }

        return false;
    }
}
