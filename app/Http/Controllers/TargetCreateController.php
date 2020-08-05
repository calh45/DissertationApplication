<?php

namespace App\Http\Controllers;

use App\DefenderWeightings;
use App\GoalkeeperWeightings;
use App\MidfielderWeightings;
use App\Player;
use App\StrikerWeightings;
use App\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class TargetCreateController extends Controller
{
    /**
     * Displays view containing form to create a Target model
     * @param $playerId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($playerId) {
        $player = Player::find($playerId); //Player the target is being set for
        $targetOptions = $this->getOptions($player->position); //Options of types of target
        $increments = ["10", "20", "30", "40", "50", "60", "70", "80", "90", "100"]; //Options of increments for target goal
        return view("targetCreate", ["player" => $player, "options" => $targetOptions, "increments" => $increments]);

    }

    /**
     * Return position dependent list of abilities that Target can be set for
     * @param $position
     * @return array
     */
    public function getOptions($position) {
        $toReturn = ["totalScore"]; //Tracked for all positions

        //Create list of abilities dependent on position
        if($position == "GK") {
            array_push($toReturn, "csScore", "saveScore", "pensSaveScore", "crossScore",
                "ballPlayScore", "commandBoxScore");
        } elseif($position == "DF") {
            array_push($toReturn, "csScore", "aerialDuelScore", "tackleScore", "shotBlockedScore",
                "pensGivenScore", "foulsScore", "ballPlayScore", "attackingThreatScore");
        } elseif($position == "MF") {
            array_push($toReturn, "goalContributionScore", "tacklesScore", "dribblesScore",
                "chancesCreatedScore", "shotTargetScore", "passesScore");
        } else {
            array_push($toReturn, "goalsScore", "assistsScore", "shotsOnTargetScore",
                "chancesCreatedScore", "penaltiesScore");
        }

        return $toReturn;
    }

    /**
     * Function to create a Target Model
     * @param Request $request
     * @param $playerId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(Request $request, $playerId) {
        $player = Player::find($playerId); //Player that target is being created for
        $targetName = request("targetName"); //Subject ability of target
        $targetIncrement = request("targetIncrement"); //What to increment current score by

        //Create Target model
        $newTarget = new Target();
        $newTarget->player_id = $player->id;
        $newTarget->target_name = request("targetName");

        //Determine Players position and retrieve weighting of ability that target is being created for
        if($player->position == "GK") {
            $thisPlayer = $player->goalkeeper;
            $toCheck = (GoalkeeperWeightings::all()->first());
            $targetWeighting = $toCheck->$targetName;
        } else if ($player->position == "DF") {
            $thisPlayer = $player->defender;
            $toCheck = (DefenderWeightings::all()->first());
            $targetWeighting = $toCheck->$targetName;
        } else if($player->position == "MF") {
            $thisPlayer = $player->midfielder;
            $toCheck = (MidfielderWeightings::all()->first());
            $targetWeighting = $toCheck->$targetName;
        } else {
            $thisPlayer = $player->striker;
            $toCheck = (StrikerWeightings::all()->first());
            $targetWeighting = $toCheck->$targetName;
        }

        //Players current score for ability that target is being created for
        $newTarget->start_score = $thisPlayer->$targetName;

        //Calculate goal score at end of target, if incremented score is larger than weighting, set target score to
        //weighting
        if($targetWeighting == 0) {
            //Scores that do not contribute to total score

            //Calculate incremented score and set for Target
            $targetScore = $thisPlayer->$targetName + ($thisPlayer->$targetName * ($targetIncrement/100));
            $newTarget->target_score = $targetScore;
        } else {
            //Scores that contribute to total score

            //Calculate incremented score
            $targetScore = $thisPlayer->$targetName + ($targetWeighting * ($targetIncrement/100));

            //If incremented score is above weighting, set to max weighting
            if($targetScore > 100) {
                $newTarget->target_score = 100;
            } else {
                $newTarget->target_score = $targetScore;
            }
        }


        //Complete Target model and save
        $newTarget->current_score = $thisPlayer->$targetName;
        $newTarget->start_date = date("Y-m-d");
        $newTarget->end_date = request("endDate");
        $newTarget->report = "";
        $newTarget->save();

        NotificationsController::create($player->user->id, "Target",
            "A new Target has been created, check Target tab to see more");

        return redirect(route("player", ["id" => $playerId]));
    }
}
