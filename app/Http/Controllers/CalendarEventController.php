<?php

namespace App\Http\Controllers;

use App\Availability;
use App\CalendarEvent;
use App\Lineup;
use App\Notification;
use App\Player;
use App\User;
use Illuminate\Http\Request;

class CalendarEventController extends Controller
{
    /**
     * Display a Calendar Event to screen.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        //Get Calendar event of interest
        $eventsToReturn = CalendarEvent::all()->where("id", $id)->first();
        //Get Lineup of interest (if it exists)
        $lineup = $this->getLineup($id);
        //Initialise positions for lineup
        $positions = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18"];
        //Retrieve players selected for lineup
        $players = $this->getPlayers($lineup);
        //Retrieve list of players marked unavailable for match
        $unavailable = Availability::all()->where("event_id", $eventsToReturn->id);

        return view("calendarEvent", ["event" => $eventsToReturn, "unavailable" => $unavailable,  "positions" => $positions,
            "lineup" => $lineup, "players" => $players]);
    }

    /**
     * Retrieves Lineup model of selected calendar event
     * @param $id
     * @return mixed|string
     */
    public function getLineup($id) {
        //Get Lineup collection
        $returned = Lineup::all()->where("match_id", $id);

        //If one exists then return lineup else return "null" identifier
        if(count($returned) > 0) {
            return $returned->first();
        } else {
            return "null";
        }
    }

    /**
     * Delete a Calendar Event
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id) {
        //Retrieve Calendar Event to delete
        $toDelete = CalendarEvent::all()->where("id", $id)->first();

        //Get list of players who need to be notified of event deletion
        $playersToNotify = $toDelete->team->players;
        foreach($playersToNotify as $player) {
            NotificationsController::create($player->user->id, "Event", $toDelete->name." ".$toDelete->location." has been deleted");
        }

        //Delete event
        $toDelete->delete();



        return redirect(route("calendar", ["2020"]));
    }

    /**
     * Retrieve list of relevant Player models for chosen lineup
     * @param $lineup
     * @return array
     */
    public function getPlayers($lineup) {
        //Initialise array to contain Player models
        $toReturn = array();

        //If lineup exists retrieve Player model for each position
        if($lineup != "null") {
            $one = User::all()->where("id", (int)$lineup->one)->first();
            $two = User::all()->where("id", (int)$lineup->two)->first();
            $three = User::all()->where("id", (int)$lineup->three)->first();
            $four = User::all()->where("id", (int)$lineup->four)->first();
            $five = User::all()->where("id", (int)$lineup->five)->first();
            $six = User::all()->where("id", (int)$lineup->six)->first();
            $seven = User::all()->where("id", (int)$lineup->seven)->first();
            $eight = User::all()->where("id", (int)$lineup->eight)->first();
            $nine = User::all()->where("id", (int)$lineup->nine)->first();
            $ten = User::all()->where("id", (int)$lineup->ten)->first();
            $eleven = User::all()->where("id", (int)$lineup->eleven)->first();
            $twelve = User::all()->where("id", (int)$lineup->twelve)->first();
            $thirteen = User::all()->where("id", (int)$lineup->thirteen)->first();
            $fourteen = User::all()->where("id", (int)$lineup->fourteen)->first();
            $fifteen = User::all()->where("id", (int)$lineup->fifteen)->first();
            $sixteen = User::all()->where("id", (int)$lineup->sixteen)->first();
            $seventeen = User::all()->where("id", (int)$lineup->seventeen)->first();
            $eighteen = User::all()->where("id", (int)$lineup->eighteen)->first();

            array_push($toReturn, $one, $two, $three, $four, $five, $six, $seven, $eight, $nine, $ten, $eleven, $twelve,
                $thirteen, $fourteen, $fifteen, $sixteen, $seventeen, $eighteen);
        }


        return $toReturn;
    }


}
