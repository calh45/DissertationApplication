<?php

namespace App\Http\Controllers;

use App\Club;
use App\Manager;
use App\Team;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;


class ClubRegisterController extends Controller
{
    public function create(Request $request) {

        //Validate entered club details for database
        $validatedDetails = $request->validate([
            "clubName" => "required",
            "creatorName" => "required",
        ]);

        if($this->existingClubCheck(request("clubName"))) {
            session()->flash('message', 'Club with this name exists already');

            return view('registerClub');
        } else {
            //Create new club model and add to database
            $newClub = new Club();
            $newClub -> clubName = $validatedDetails["clubName"];
            $newClub -> clubCreator = $validatedDetails["creatorName"];
            $newClub->save();

            $createdClub = Club::all()->where("clubName", $validatedDetails["clubName"])->first();

            //Cycle through each team selected and create manager model and team model
            foreach ($_POST['teams'] as $teams) {
                $dateToUse = Carbon::now();
                //Create team model and add to the database
                $tempTeam = new Team();
                $tempTeam -> teamName = $teams;
                $tempTeam -> clubId = $createdClub->id;
                $tempTeam -> managerId = null;
                $tempTeam -> managerEmail = request($teams."ManagerEmail");
                $tempTeam -> subscription = 00.00;
                $tempTeam -> subscriptionDate = $dateToUse;
                $tempTeam -> save();


            }

            //Send alert that club was successfully created
            session()->flash('message', 'Club registered');

            return view('registerClub');
        }

    }

    public function existingClubCheck($toCheck) {
        $existingClubs = Club::all()->where("clubName", $toCheck);
        if(count($existingClubs) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
