<?php

namespace App\Http\Controllers;

global $suggestedTargets;
$suggestedTargets = [];

use App\Defender;
use App\Goalkeeper;
use App\Midfielder;
use App\Player;
use App\Striker;
use App\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Array_;

class PlayerController extends Controller
{
    public function show($id) {
        $player = Player::findorFail($id);
        $positionedPlayer = $this->getPositionedPlayer($player);
        $statLabels = $this->labelFinder($player);
        $stats = $this->getStats($player);
        $observations = $this->getObservations($player);
        $targets = Target::all()->where("player_id", $player->id);
        global $suggestedTargets;


        return view("playerProfileM")->with(["player" => $player, "statLabels" => $statLabels, "stats" => $stats,
            "observations" => $observations, "targets" => $targets, "positionedPlayer" => $positionedPlayer, "suggestedTargets" => $suggestedTargets]);
    }

    public function getPositionedPlayer($player) {
        if($player->position === "GK") {
            return $player->goalkeeper;
        } elseif($player->position === "DF") {
            return $player->defender;
        } elseif($player->position === "MF") {
            return $player->midfielder;
        } else {
            return $player->striker;
        }
    }

    public function saveImage(Request $request) {

        //Store uploaded Image within application
        $destinationToSave = public_path("/images/profileImages");
        $imageToSave = $request->file("imageSave");
        $imageName = date('YmdHis').".".$imageToSave->getClientOriginalExtension();
        $imageToSave->move($destinationToSave, $imageName);

        $user = Auth::user();
        $player = $user->player->id;

        $user->profileImage = "/profileImages/".$imageName;
        $user->save();

        return redirect("/playerHome");
    }

    public function labelFinder($player) {
        if($player->position === "GK") {
            return ["Clean Sheets", "Shots Faced", "Shots Saved", "Pens Faced", "Pens Saved", "Pens Given Away", "Crosses Claimed"];
        } elseif($player->position === "DF") {
            return ["Clean Sheets", "Aerial Duels Won", "Aerial Duels Lost", "Tackles Attempted", "Tackles Won", "Shots Blocked", "Pens Given Away"];
        } elseif($player->position === "MF") {
            return ["Tackles Attempted", "Tackles Won", "Dribbles Attempted", "Successful Dribbles", "Chances Created", "Shots", "Shots On Target"];
        } elseif($player->position === "FW") {
            return ["Chances Created", "Shots", "Shots On Target", "Headed Goals", "Penalties Taken", "Penalties Scored"];
        }
    }

    public function getStats($player) {
        $arrayToReturn = array();
        if($player->position === "GK") {
            $labels = ["cleanSheets", "shotsFaced", "shotsSaved", "pensFaced", "pensSaved", "pensGivenAway", "crossesClaimed"];

            foreach($labels as $label) {
                array_push($arrayToReturn, $player->goalkeeper->$label);
            }
        } elseif($player->position === "DF") {
            $labels = ["cleanSheets", "aerialDuelsWon", "aerialDuelsLost", "tacklesAttempted", "tacklesWon", "shotsBlocked", "pensGivenAway"];

            foreach($labels as $label) {
                array_push($arrayToReturn, $player->defender->$label);
            }
        } elseif($player->position == "MF") {
            $labels = ["tacklesAttempted", "tacklesWon", "dribblesAttempted", "successfullDribbles", "chancesCreated", "shots", "shotsOnTarget"];

            foreach($labels as $label) {
                array_push($arrayToReturn, $player->midfielder->$label);
            }
        } elseif($player-> position === "FW") {
            $labels = ["chancesCreated", "shots", "shotsOnTarget", "headedGoals", "penaltiesTaken", "penaltiesScored"];

            foreach($labels as $label) {
                array_push($arrayToReturn, $player->striker->$label);
            }
        }

        return $arrayToReturn;

    }

    public function getObservations($player) {
        global $suggestedTargets;
        $toReturn = array();

        if($player->position === "GK" && $player->appearances >= 5) {
            global $suggestedTargets;
            //Array of players in that age group
            $ageGroupArray = [];
            //Check Overall Score
            $toCheck = Goalkeeper::orderBy("totalScore", "desc")->get();
            $indexCount = 0;

            //Check each player for if they are in desired age group
            foreach($toCheck as $singleToCheck) {
                if($player->team->teamName == $singleToCheck->player->team->teamName) {
                    array_push($ageGroupArray, $singleToCheck);
                }
            }

            //Loop through array of age group players and find index of player of interest
            while($player->goalkeeper->id != $ageGroupArray[$indexCount]->id && $indexCount < count($ageGroupArray)) {
                $indexCount++;
            }

            //Calculate buffer zone of "average" players
            $averageBuffer = (int)(count($ageGroupArray) * 0.1);

            //If player index is smaller than first index of buffer zone then performing above average, if larger than
            //last index of buffer zone then performing below
            if($indexCount < (((int)count($ageGroupArray)/2)-$averageBuffer) ) {
                array_push($toReturn, "Performing above average for this players age group");
            }elseif($indexCount > (((int)count($ageGroupArray)/2)+$averageBuffer)) {
                array_push($toReturn, "Performing below average for this players age group");
                //If an existing target for this observation does not exist, create suggested target
                if($this->existingTargetCheck($player->id, "totalScore") == false) {
                    global $suggestedTargets;
                    array_push($suggestedTargets, "totalScore");
                }

            }

            //Check Commanding box
            $ageGroupArray = [];
            $toCheck = Goalkeeper::orderBy("commandBoxScore", "desc")->get();
            $indexCount = 0;

            //Check each player for if they are in desired age group
            foreach($toCheck as $singleToCheck) {
                if($player->team->teamName == $singleToCheck->player->team->teamName) {
                    array_push($ageGroupArray, $singleToCheck);
                }
            }

            //Loop through array of age group players and find index of player of interest
            while($player->goalkeeper->id != $ageGroupArray[$indexCount]->id && $indexCount < count($ageGroupArray)) {
                $indexCount++;
            }

            //Calculate buffer zone of "average" players
            $averageBuffer = (int)(count($ageGroupArray) * 0.1);

            //If player index is smaller than first index of buffer zone then performing above average, if larger than
            //last index of buffer zone then performing below
            if($indexCount < (((int)count($ageGroupArray)/2)-$averageBuffer) ) {
                array_push($toReturn, "Commands Box well for player in this age group");
            }elseif($indexCount > (((int)count($ageGroupArray)/2)+$averageBuffer)) {
                array_push($toReturn, "Commands Box poorly for player in this age group");
                if($this->existingTargetCheck($player->id, "commandBoxScore") == false) {
                    global $suggestedTargets;
                    array_push($suggestedTargets, "commandBoxScore");
                }
            }else {
                array_push($toReturn, "Average at commanding box");
            }

            //Check ball playing
            $ageGroupArray = [];
            $toCheck = Goalkeeper::orderBy("ballPlayScore", "desc")->get();
            $indexCount = 0;

            //Check each player for if they are in desired age group
            foreach($toCheck as $singleToCheck) {
                if($player->team->teamName == $singleToCheck->player->team->teamName) {
                    array_push($ageGroupArray, $singleToCheck);
                }
            }

            //Loop through array of age group players and find index of player of interest
            while($player->goalkeeper->id != $ageGroupArray[$indexCount]->id && $indexCount < count($ageGroupArray)) {
                $indexCount++;
            }

            //Calculate buffer zone of "average" players
            $averageBuffer = (int)(count($ageGroupArray) * 0.1);

            //If player index is smaller than first index of buffer zone then performing above average, if larger than
            //last index of buffer zone then performing below
            if($indexCount < (((int)count($ageGroupArray)/2)-$averageBuffer) ) {
                array_push($toReturn, "Good ability on the ball for this age group");
            }elseif($indexCount > (((int)count($ageGroupArray)/2)+$averageBuffer)) {
                array_push($toReturn, "Poor ability on the ball for this age group");
                if($this->existingTargetCheck($player->id, "ballPlayScore") == false) {
                    global $suggestedTargets;
                    array_push($suggestedTargets, "ballPlayScore");
                }
            }


        } elseif ($player->position == "DF" && $player->appearances >= 5) {
            global $suggestedTargets;

            //Array of players in that age group
            $ageGroupArray = [];

            //Check Overall Score
            $toCheck = Defender::orderBy("totalScore", "desc")->get();
            $i = 0;

            //Check each player for if they are in desired age group
            foreach($toCheck as $singleToCheck) {
                if($player->team->teamName == $singleToCheck->player->team->teamName) {
                    array_push($ageGroupArray, $singleToCheck);
                }
            }

            //Loop through array of age group players and find index of player of interest
            while($player->defender->id != $ageGroupArray[$i]->id && $i < count($ageGroupArray)) {
                $i++;
            }

            //Calculate buffer zone of "average" players
            $averageBuffer = (int)(count($ageGroupArray) * 0.1);

            //If player index is smaller than first index of buffer zone then performing above average, if larger than
            //last index of buffer zone then performing below
            if($i < (((int)count($ageGroupArray)/2)-$averageBuffer) ) {
                array_push($toReturn, "Performing above average for this players age group");
            }elseif($i > (((int)count($ageGroupArray)/2)+$averageBuffer)) {
                array_push($toReturn, "Performing below average for this players age group");
                if($this->existingTargetCheck($player->id, "totalScore") == false) {
                    global $suggestedTargets;
                    array_push($suggestedTargets, "totalScore");
                }
            }


        } elseif ($player->position == "MF" && $player->appearances >=5) {
            global $suggestedTargets;
            //Array of players in that age group
            $ageGroupArray = [];

            //Check Overall Score
            $toCheck = Midfielder::orderBy("totalScore", "desc")->get();
            $i = 0;

            //Check each player for if they are in desired age group
            foreach($toCheck as $singleToCheck) {
                if($player->team->teamName == $singleToCheck->player->team->teamName) {
                    array_push($ageGroupArray, $singleToCheck);
                }
            }

            //Loop through array of age group players and find index of player of interest
            while($player->midfielder->id != $ageGroupArray[$i]->id && $i < count($ageGroupArray)) {
                $i++;
            }

            //Calculate buffer zone of "average" players
            $averageBuffer = (int)(count($ageGroupArray) * 0.1);

            //If player index is smaller than first index of buffer zone then performing above average, if larger than
            //last index of buffer zone then performing below
            if($i < (((int)count($ageGroupArray)/2)-$averageBuffer) ) {
                array_push($toReturn, "Performing above average for this players age group");
            }elseif($i > (((int)count($ageGroupArray)/2)+$averageBuffer)) {
                array_push($toReturn, "Performing below average for this players age group");
                if($this->existingTargetCheck($player->id, "totalScore") == false) {
                    global $suggestedTargets;
                    array_push($suggestedTargets, "totalScore");
                }
            }

            //Check attack vs defend score
            $attScore = $player->midfielder->attScore;
            $defScore = $player->midfielder->defScore;
            $bufferZone = 10;

            if($attScore > ($defScore + $bufferZone)) {
                array_push($toReturn, "Performing better as an attacking midfielder");
            } elseif($defScore > ($attScore + $bufferZone)) {
                array_push($toReturn, "Performing better as a defensive midfielder");
            }
        } elseif ($player->position == "FW" && $player->appearances >=5) {
            global $suggestedTargets;
            //Array of players in that age group
            $ageGroupArray = [];

            //Check Overall Score
            $toCheck = Striker::orderBy("totalScore", "desc")->get();
            $i = 0;

            //Check each player for if they are in desired age group
            foreach($toCheck as $singleToCheck) {
                if($player->team->teamName == $singleToCheck->player->team->teamName) {
                    array_push($ageGroupArray, $singleToCheck);
                }
            }

            //Loop through array of age group players and find index of player of interest
            while($player->striker->id != $ageGroupArray[$i]->id && $i < count($ageGroupArray)) {
                $i++;
            }

            //Calculate buffer zone of "average" players
            $averageBuffer = (int)(count($ageGroupArray) * 0.1);

            //If player index is smaller than first index of buffer zone then performing above average, if larger than
            //last index of buffer zone then performing below
            if($i < (((int)count($ageGroupArray)/2)-$averageBuffer) ) {
                array_push($toReturn, "Performing above average for this players age group");
            }elseif($i > (((int)count($ageGroupArray)/2)+$averageBuffer)) {
                array_push($toReturn, "Performing below average for this players age group");
                if($this->existingTargetCheck($player->id, "totalScore") == false) {
                    global $suggestedTargets;
                    array_push($suggestedTargets, "totalScore");
                }
            }

            //Check if better in midfield
            if($player->striker->goalsScore <= 10 && $player->striker->assistsScore >= 9 && $player->striker->chancesCreatedScore >= 9) {
                array_push($toReturn, "May be better played as a midfielder");

            }

            //Check headed goals
            if($player->goals > 0 && ($player->striker->headedGoals / $player->goals) >= 0.5) {
                array_push($toReturn, "High percentage of headed goals");
            }

            //Check Penalties
            if($player->striker->penaltiesScore >= 8) {
                array_push($toReturn, "Good penalty taker");
            } else {
                if($this->existingTargetCheck($player->id, "penaltiesScore") == false) {
                    global $suggestedTargets;
                    array_push($suggestedTargets, "penaltiesScore");
                }
            }


        }
        return $toReturn;
    }

    public function fourCornerUpdate(Request $request, $playerId) {
        $playerToUpdate = Player::find($playerId);

        $toCheckArray = ["technical", "psychological", "physical", "social"];

        foreach ($toCheckArray as $toCheck) {
            if(strlen(request($toCheck)) > 0) {
                $playerToUpdate->$toCheck = request($toCheck);
            }
        }

        $playerToUpdate->save();

        return redirect(route("player", ["id" => $playerId]));
    }

    public function existingTargetCheck($playerId, $targetName) {
        $toCheck = Target::all()->where("player_id", $playerId)->where("target_name", $targetName);

        if(count($toCheck) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
