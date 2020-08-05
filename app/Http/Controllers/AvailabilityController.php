<?php

namespace App\Http\Controllers;

use App\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    /**
     * Creates Availability Model
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create($id, Request $request) {
        //Get choice (Available or Unavailable
        $choice = request("availableChoice");
        //Retrieve User making this choice
        $loggedIn = Auth::user();
        //Collect any existing Availability models for this Player for this Calendar Event
        $existingRecords = Availability::all()->where("event_id", $id)->where("user_id", $loggedIn->id)->first();

        //As availability is preset, if the choice is available then any existing unavailable records can be deleted
        //If choice is Unavailable and no pre records of this exist, create a new record.
        if($choice === "unavailable" && $existingRecords == null) {
            $newAvailability = new Availability();
            $newAvailability -> user_id = $loggedIn->id;
            $newAvailability -> event_id = $id;
            $newAvailability -> team_id = $loggedIn->player->team->teamId;
            $newAvailability -> available = 0;
            $newAvailability->save();
        } elseif ($choice === "available") {
            $existingRecords->delete();

        }

        return redirect(route("calendarEvent", $id));
    }
}
