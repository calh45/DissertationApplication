<?php

namespace App\Http\Controllers;

use App\CalendarEvent;
use App\Defender;
use App\Event;
use App\Goalkeeper;
use App\Lineup;
use App\MatchStatistics;
use App\Midfielder;
use App\Striker;
use App\User;
use Illuminate\Http\Request;

class MatchStatisticsController extends Controller
{
    /**
     * Display page to collect match statistics to screen
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id) {

        $eventToReturn = CalendarEvent::all()->where("id", $id)->first(); //Match event to collect statistics for
        $matchStatistic = MatchStatistics::all()->where("event_id", $id)->first(); //Collect any existing records for this match event
        $lineup = $this->getLineup($id); //Lineup model for match event
        $players = $this->getPlayers($lineup); //Players in lineup model
        $playerStats = ["yc", "rc", "goals", "assists", "pa", "pc", "fouls"]; //Collected stats for general player
        $gkStats = ["cs", "sf", "ss", "pf", "ps", "pga", "cc"]; //Collected stats for goalkeeper
        $dfStats = ["cs", "adw", "adl", "ta", "tw", "sb", "pga"]; //Collected stats for defender
        $mfStats = ["ta", "tw", "da", "sd", "cc", "shots", "sot"]; //Collected stats for midfielder
        $fwStats = ["cc", "shots", "sot", "headedG", "pensT", "pensS"]; //Collected stats for forward



        return view("matchStatistics", ["event" => $eventToReturn, "matchStatistic" => $matchStatistic, "lineup" => $lineup,
            "players" => $players, "playerStats" => $playerStats, "gkStats" => $gkStats, "dfStats" => $dfStats,
            "mfStats" => $mfStats, "fwStats" => $fwStats]);

    }

    /**
     * Function to return Lineup model (if exists) for relevant Match event
     * @param $id
     * @return mixed|string
     */
    public function getLineup($id) {
        $returned = Lineup::all()->where("match_id", $id); //Relevant Lineup model

        //If a Lineup model exists, return it, else return null
        if(count($returned) > 0) {
            return $returned->first();
        } else {
            return "null";
        }
    }

    /**
     * Return array of Player models for each player id listed in Lineup model
     * @param $lineup
     * @return array
     */
    public function getPlayers($lineup) {
        $starting = ["one","two","three","four","five","six","seven","eight","nine","ten", "eleven"]; //Starting positions
        $subs = ["twelve","thirteen","fourteen","fifteen","sixteen","seventeen","eighteen"]; //Substitute positions
        $toReturn = array(); //Array to hold players

        //If lineup model exists, retrieve Player models else return empty array
        if($lineup != "null") {
            //Retrieve Player model for each starting position
            foreach ($starting as $thisIndex) {
                $toAdd = $this->getPlayer($lineup->$thisIndex);
                array_push($toReturn, $toAdd);
            }

            //Retrieve Player model for each substitute position that is not null
            foreach ($subs as $thisIndex) {
                if($lineup->$thisIndex != null) {
                    $toAdd = $this->getPlayer($lineup->$thisIndex);
                    array_push($toReturn, $toAdd);
                }
            }
        }

        return $toReturn;
    }

    /**
     * Retrieve Player model for a relevant player id
     * @param $playerId
     * @return |null
     */
    public function getPlayer($playerId) {
        //If id is null then return null else retrieve Player model
        if($playerId == null) {
            return null;
        } else {
            $userAccount = User::all()->where("id", $playerId)->first();
            $toReturn = $userAccount->player;

            return $toReturn;
        }

    }

    /**
     * Function to save match statistics for a Match Event
     * @param $lineupId
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveStats($lineupId, Request $request) {
        $lineup = $this->getLineup($lineupId); //Lineup model for Match Event
        $players = $this->getPlayers($lineup); //Array of Player models for Lineup

        //Loop through each player in lineup and increment their relevant statistics by collected match statistics value
        foreach($players as $player) {
            //Update generic Player stats
            $player->appearances = ($player->appearances) + 1;
            $player->yellowCards = ($player->yellowCards) + (int)request("$player->id"."yc");
            $player->redCards = ($player->redCards) + (int)request("$player->id"."rc");
            $player->goals = ($player->goals) + (int)request("$player->id"."goals");
            $player->assists = ($player->assists) + (int)request("$player->id"."assists");
            $player->passesAttempted = ($player->passesAttempted) + (int)request("$player->id"."pa");
            $player->passesCompleted = ($player->passesCompleted) + (int)request("$player->id"."pc");
            $player->fouls = ($player->fouls) + (int)request("$player->id"."fouls");

            //Update statistics specific to players position
            if($player->position === "GK") {
                $goalkeeper = Goalkeeper::all()->where("playerId", $player->id)->first(); //Collect players relevant Goalkeeper model

                //Update Goalkeeper stats
                $goalkeeper->cleanSheets = ($goalkeeper->cleanSheets) + (int)request("$player->id"."cs");
                $goalkeeper->shotsFaced = ($goalkeeper->shotsFaced) + (int)request("$player->id"."sf");
                $goalkeeper->shotsSaved = ($goalkeeper->shotsSaved) + (int)request("$player->id"."ss");
                $goalkeeper->pensFaced = ($goalkeeper->pensFaced) + (int)request("$player->id"."pf");
                $goalkeeper->pensSaved = ($goalkeeper->pensSaved) + (int)request("$player->id"."ps");
                $goalkeeper->pensGivenAway = ($goalkeeper->pensGivenAway) + (int)request("$player->id"."pga");
                $goalkeeper->crossesClaimed = ($goalkeeper->crossesClaimed) + (int)request("$player->id"."cc");
                $goalkeeper->save();
            } elseif($player->position === "DF") {
                $defender = Defender::all()->where("playerId", $player->id)->first(); //Collect players relevant Defender model

                //Update Defender stats
                $defender->cleanSheets = ($defender->cleanSheets) + (int)request("$player->id"."cs");
                $defender->aerialDuelsWon = ($defender->aerialDuelsWon) + (int)request("$player->id"."adw");
                $defender->aerialDuelsLost = ($defender->aerialDuelsLost) + (int)request("$player->id"."adl");
                $defender->tacklesAttempted = ($defender->tacklesAttempted) + (int)request("$player->id"."ta");
                $defender->tacklesWon = ($defender->tacklesWon) + (int)request("$player->id"."tw");
                $defender->shotsBlocked = ($defender->shotsBlocked) + (int)request("$player->id"."sb");
                $defender->pensGivenAway = ($defender->pensGivenAway) + (int)request("$player>id"."pga");
                $defender->save();
            } elseif($player->position === "MF") {
                $midfielder = Midfielder::all()->where("playerId", $player->id)->first(); //Collect players relevant Midfielder model

                //Update Midfielder stats
                $midfielder->tacklesAttempted = ($midfielder->tacklesAttempted) + (int)request("$player->id"."ta");
                $midfielder->tacklesWon = ($midfielder->tacklesWon) + (int)request("$player->id"."tw");
                $midfielder->dribblesAttempted = ($midfielder->dribblesAttempted) + (int)request("$player->id"."da");
                $midfielder->successfullDribbles = ($midfielder->successfullDribbles) + (int)request("$player->id"."sd");
                $midfielder->chancesCreated = ($midfielder->chancesCreated) + (int)request("$player->id"."cc");
                $midfielder->shots = ($midfielder->shots) + (int)request("$player->id"."shots");
                $midfielder->shotsOnTarget = ($midfielder->shotsOnTarget) + (int)request("$player->id"."sot");
                $midfielder->save();
            } elseif($player->position === "FW") {
                $striker = Striker::all()->where("playerId", $player->id)->first(); //Collect players relevant Striker model

                //Update Striker stats
                $striker->chancesCreated = ($striker->chancesCreated) + (int)request("$player->id"."cc");
                $striker->shots = ($striker->shots) + (int)request("$player->id"."shots");
                $striker->shotsOnTarget = ($striker->shotsOnTarget) + (int)request("$player->id"."sot");
                $striker->headedGoals = ($striker->headedGoals) + (int)request("$player->id"."headedG");
                $striker->penaltiesTaken = ($striker->pensTaken) + (int)request("$player->id"."pensT");
                $striker->penaltiesScored = ($striker->pensScored) + (int)request("$player->id"."pensS");
                $striker->save();
            }

            $player->save();

        }

        //Create Match Statistics model for relevant Match as proof that statistics have been collected
        $newMatchStatistics = new MatchStatistics();
        $newMatchStatistics->match_id = $lineup->match_id;


        return redirect(route("matchStats", ["id" => $lineup->match_id]));
    }
}
