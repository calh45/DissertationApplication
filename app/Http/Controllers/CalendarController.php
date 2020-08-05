<?php

namespace App\Http\Controllers;

use App\CalendarEvent;
use App\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Initialise screen to display calendar
     * @param $year
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($year) {
        $user = Auth()->user();

        //Retrieve team of logged in account
        if($user->accountType == "M"){
            $team = $user->manager->team->teamId;
        } else {
            $team = $user->player->team->teamId;
        }

        //Get all Calendar Event Items
        $events = CalendarEvent::orderBy('task_date')->get();

        //Initialise Arrays to split events into respective months
        $jan = array();
        $feb = array();
        $march = array();
        $april = array();
        $may = array();
        $june = array();
        $july = array();
        $august = array();
        $sept = array();
        $oct = array();
        $nov = array();
        $dec = array();

        //Loop through calendar events and store in relevant month array
        foreach ($events as $event) {
            if((Carbon::parse($event->task_date)->year == $year) && ($event->team_id == $team)) {
                $dateToCheck = $event->task_date;
                $splitDate = explode("-", $dateToCheck);

                if($splitDate[1] === "01") {
                    $jan[] = $event;
                }elseif($splitDate[1] === "02") {
                    $feb[] = $event;
                }elseif($splitDate[1] === "03") {
                    $march[] = $event;
                }elseif($splitDate[1] === "04") {
                    $april[] = $event;
                }elseif($splitDate[1] === "05") {
                    $may[] = $event;
                }elseif($splitDate[1] === "06") {
                    $june[] = $event;
                }elseif($splitDate[1] === "07") {
                    $july[] = $event;
                }elseif($splitDate[1] === "08") {
                    $august[] = $event;
                }elseif($splitDate[1] === "09") {
                    $sept[] = $event;
                }elseif($splitDate[1] === "10") {
                    $oct[] = $event;
                }elseif($splitDate[1] === "11") {
                    $nov[] = $event;
                }elseif($splitDate[1] === "12") {
                    $dec[] = $event;
                }
            }
        }


        return view("calendar", ["jan" => $jan, "feb" => $feb, "march" => $march, "april" => $april, "may" => $may,
            "june" => $june, "july" => $july, "august" => $august, "sept" => $sept, "oct" => $oct, "nov" => $nov, "dec" => $dec]);
    }

    /**
     * Create new Calendar event.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createEvent(Request $request) {
        //Retrieve Team of logged in User
        $user = Auth()->user();
        $team = $user->manager->team;

        //Create Calendar Event
        $newEvent = new CalendarEvent();
        $newEvent->name = request("eventName");
        $newEvent->event_type = request("eventType");
        $newEvent->location = request("location");
        $newEvent->task_date = Carbon::parse(request("dateTime"));
        $newEvent->team_id = $team->teamId;


        //Get list of players who need to be notified of event creation
        $playersToNotify = $team->players;
        foreach($playersToNotify as $player) {
            NotificationsController::create($player->user->id, "Event", $newEvent->name." ".$newEvent->location." has been created");
        }

        $newEvent->save();
        return redirect(route("calendar", ["year" => 2020]));

    }

    /**
     * Reinitialise screen with calendar events from chosen year.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function change(Request $request) {
        //Get chosen year
        $newYear = request("yearRequest");

        return redirect(route("calendar", ["year" => $newYear]));
    }


}
