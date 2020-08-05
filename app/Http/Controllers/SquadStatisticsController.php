<?php

namespace App\Http\Controllers;

use App\Defender;
use App\Goalkeeper;
use App\Midfielder;
use App\Player;
use App\Promotion;
use App\Striker;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Array_;
use SebastianBergmann\Environment\Console;

class SquadStatisticsController extends Controller
{

    /**
     * Display Squad Statistics view to screen
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $youngerSquadPerformers = $this->getYoungerPerformers(); //Best performing players in younger squads
        global $suggestedArray;
        $suggestedArray = []; //Suggested players to promote based on current squads lacking areas
        $this->getSuggestedPromotions(Auth::user()->manager->team); //Retrieve suggested promotions
        $promotedPlayers = $this->getPromotedPlayers(); //List of players already promoted from younger squads

        return view("squadStatistics", ["bestPerformers" => $youngerSquadPerformers,
            "suggestedPromotions" => $suggestedArray, "promotions" => $promotedPlayers]);
    }

    /**
     * Function to get array of best performing players from Squads 1 or 2 age groups below current squad
     * @return array
     */
    public function getYoungerPerformers() {
        $toReturn = [];

        //Find which teams to check
        $teamsToCheck = $this->findTeams();

        $teamCount = 0; //Counter of which team is being checked

        //Collect best performing players in each team
        foreach($teamsToCheck as $teamToCheck) {
            //All players listed in descending order of their total score
            $players = Player::orderBy("totalScore", "desc")->where("teamId", $teamToCheck->teamId)->get();

            //Loop through each player
            foreach ($players as $player) {
                //Set score threshold depending on level of age group (1 level below current squad = 60, 2 levels = 70)
                if($teamCount = 0) {
                    $threshold = 60;
                } else if($teamCount = 1) {
                    $threshold = 70;
                }

                //If players total score is larger than threshold, add to list
                if($player->totalScore > $threshold) {
                    array_push($toReturn, $player);
                }
            }

            $teamCount += 1;
        }

        return $toReturn;

    }

    /**
     * Function to return array of players from younger squads that are suggested to be promoted
     * @param $originalTeam
     */
    public function getSuggestedPromotions($originalTeam) {
        global $suggestedArray;

        //Find teams to check
        $teamsToCheck = $this->findTeams();

        //Check each position of each team
        foreach($teamsToCheck as $teamToCheck) {
            $this->goalkeeperCheck($suggestedArray, $originalTeam, $teamToCheck);
            $this->defenderCheck($suggestedArray, $originalTeam, $teamToCheck);
            $this->midfielderCheck($suggestedArray, $originalTeam, $teamToCheck);
            $this->strikerCheck($suggestedArray, $originalTeam, $teamToCheck);
        }

    }

    /**
     * Function to return every Goalkeeper from a team that is suggested to be promoted
     * @param $toReturn
     * @param $originalTeam
     * @param $teamToCheck
     */
    public function goalkeeperCheck($toReturn, $originalTeam, $teamToCheck) {
        global $suggestedArray;

        //Abilities to check
        $checklist = ["totalScore", "ballPlayScore", "crossScore"];

        //Loop through each ability
        foreach($checklist as $check) {
            $tempScores = []; //Holds values of every player for ability that is being checked

            //Loop through each goalkeeper of managers current team and collect their relevant score
            $players = Goalkeeper::all();
            foreach ($players as $player) {
                if($player->player->team->teamId == $originalTeam->teamId) {
                    array_push($tempScores, $player->$check);
                }

            }

            //If there is at least one goalkeeper, perform analysis
            if(count($tempScores) > 0) {
                //Calculate mean of all scores from current team
                $average = array_sum($tempScores) / count($tempScores);

                //Loop through each Goalkeeper of teams in younger age groups to check if their score is higher than average
                $players = Goalkeeper::all();
                foreach ($players as $player) {
                    //If current Goalkeepers score for relevant ability is higher than average of current team, add Goalkeeper
                    if($player->$check > $average && $player->player->team->teamId == $teamToCheck->teamId) {
                        $toPush = [];
                        array_push($toPush, $player);

                        //Add explanation for relevant score
                        if($check == "totalScore") {
                            array_push($toPush, "overall performance", $average, $player->$check);
                        } elseif($check == "ballPlayScore") {
                            array_push($toPush, "ability on the ball", $average, $player->$check);
                        } elseif($check == "crossScore") {
                            array_push($toPush, "ability to claim crosses", $average, $player->$check);
                        }
                        array_push($suggestedArray, $toPush);
                    }
                }

            }
        }
    }

    /**
     * Function to return every Defender from a team that is suggested to be promoted
     * @param $toReturn
     * @param $originalTeam
     * @param $teamToCheck
     */
    public function defenderCheck($toReturn, $originalTeam, $teamToCheck) {
        global $suggestedArray;

        //Abilities to check
        $checklist = ["totalScore", "ballPlayScore", "attackingThreatScore"];

        //Loop through each ability
        foreach($checklist as $check) {
            $tempScores = []; //Holds values of every player for ability that is being checked

            //Loop through each defender of managers current team and collect their relevant score
            $players = Defender::all();
            foreach ($players as $player) {
                if($player->player->team->teamId == $originalTeam->teamId) {
                    array_push($tempScores, $player->$check);
                }

            }

            //If there is at least one defender, perform analysis
            if(count($tempScores) > 0) {
                //Calculate mean of all scores from current team
                $average = array_sum($tempScores) / count($tempScores);

                //Loop through each Defender of teams in younger age groups to check if their score is higher than average
                $players = Defender::all();
                foreach ($players as $player) {
                    //If current Defender score for relevant ability is higher than average of current team, add Defender
                    if($player->$check > $average && $player->player->team->teamId == $teamToCheck->teamId) {
                        $toPush = [];
                        array_push($toPush, $player);

                        //Add explanation for relevant score
                        if($check == "totalScore") {
                            array_push($toPush, "overall performance", $average, $player->$check);
                        } elseif($check == "ballPlayScore") {
                            array_push($toPush, "ability on the ball", $average, $player->$check);
                        } elseif($check == "attackingThreatScore") {
                            array_push($toPush, "ability to score goals", $average, $player->$check);
                        }
                        array_push($suggestedArray, $toPush);
                    }
                }

            }
        }
    }

    /**
     * Function to return every Midfielder from a team that is suggested to be promoted
     * @param $toReturn
     * @param $originalTeam
     * @param $teamToCheck
     */
    public function midfielderCheck($toReturn, $originalTeam, $teamToCheck) {
        global $suggestedArray;

        //Abilities to check
        $checklist = ["totalScore", "defScore", "attScore"];

        //Loop through each ability
        foreach($checklist as $check) {
            $tempScores = []; //Holds values of every player for ability that is being checked

            //Loop through each midfielder of managers current team and collect their relevant score
            $players = Midfielder::all();
            foreach ($players as $player) {
                if($player->player->team->teamId == $originalTeam->teamId) {
                    array_push($tempScores, $player->$check);
                }

            }

            //If there is at least one Midfielder, perform analysis
            if(count($tempScores) > 0) {
                //Calculate mean of all scores from current team
                $average = array_sum($tempScores) / count($tempScores);

                //Loop through each Midfielder of teams in younger age groups to check if their score is higher than average
                $players = Midfielder::all();
                foreach ($players as $player) {
                    //If current Midfielder score for relevant ability is higher than average of current team, add Midfielder
                    if($player->$check > ($average + 0.3*$average) && $player->player->team->teamId == $teamToCheck->teamId) {
                        $toPush = [];
                        array_push($toPush, $player);

                        //Add explanation for relevant score
                        if($check == "totalScore") {
                            array_push($toPush, "overall performance", $average, $player->$check);
                        } elseif($check == "defScore") {
                            array_push($toPush, "performance as a defensive midfielder", $average,
                                $player->$check);
                        } elseif($check == "attScore") {
                            array_push($toPush, "performance as an attacking midfielder", $average,
                                $player->$check);
                        }
                        array_push($suggestedArray, $toPush);
                    }
                }

            }
        }
    }

    /**
     * Function to return every Forward from a team that is suggested to be promoted
     * @param $toReturn
     * @param $originalTeam
     * @param $teamToCheck
     */
    public function strikerCheck($toReturn, $originalTeam, $teamToCheck) {
        global $suggestedArray;

        //Abilities to check
        $checklist = ["totalScore", "penaltiesScore", "goalsScore"];

        //Loop through each ability
        foreach($checklist as $check) {
            $tempScores = []; //Holds values of every player for ability that is being checked

            //Loop through each striker of managers current team and collect their relevant score
            $players = Striker::all();
            foreach ($players as $player) {
                if($player->player->team->teamId == $originalTeam->teamId) {
                    array_push($tempScores, $player->$check);
                }

            }

            //If there is at least one Striker, perform analysis
            if(count($tempScores) > 0) {
                //Calculate mean of all scores from current team
                $average = array_sum($tempScores) / count($tempScores);

                //Loop through each Striker of teams in younger age groups to check if their score is higher than average
                $players = Striker::all();
                $pushedPlayers = [];
                foreach ($players as $player) {
                    //If current Striker score for relevant ability is higher than average of current team, add Striker
                    if($player->$check > ($average + 0.3*$average) && $player->player->team->teamId == $teamToCheck->teamId) {
                        $toPush = [];
                        array_push($toPush, $player);

                        //Add explanation for relevant score
                        if($check == "totalScore") {
                            array_push($toPush, "overall performance", $average, $player->$check);
                            array_push($pushedPlayers, $player);
                        } elseif($check == "penaltiesScore") {
                            array_push($toPush, "ability to score penalties", $average, $player->$check);
                            array_push($pushedPlayers, $player);
                        } elseif($check == "goalsScore") {
                            array_push($toPush, "prolificness at finishing chances", $average,
                                $player->$check);
                            array_push($pushedPlayers, $player);
                        }

                        array_push($suggestedArray, $toPush);
                    }
                }

            }
        }
    }

    /**
     * Function to find teams to check for players to promote (returns array of 0,1 or 2 teams)
     * @return array
     */
    public function findTeams() {
        //All teams
        $teams = ["under9", "under10", "under11", "under12", "under13", "under14", "under15", "under16", "under18",
            "under21", "seniors"];

        //Team to promote to
        $originalTeam = Auth::user()->manager->team;

        //Index of team to promote to
        $originalTeamIndex = array_search($originalTeam->teamName, $teams)-1;

        //Index of lowest age group team to promote from
        $lowestTeamToCheck = $originalTeamIndex - 2;
        if($lowestTeamToCheck < 0) {
            $lowestTeamToCheck = 0;
        }

        $teamsToCheck = [];

        //For each index, if a team exists, add to array until either two teams have been added or run out of teams
        for($originalTeamIndex; $originalTeamIndex > $lowestTeamToCheck && count($teamsToCheck) < 2; $originalTeamIndex--) {

            $tempCheck = Team::all()->where("clubId", $originalTeam->clubId)->where("teamName",
                $teams[$originalTeamIndex]);
            if(count($tempCheck) > 0) {
                array_push($teamsToCheck, $tempCheck->first());
            }
        }
        return $teamsToCheck;
    }


    /**
     * Function to promote a player to current squad
     * @param $playerId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function promotePlayer($playerId) {
        $playerToPromote = Player::all()->where("id", $playerId)->first(); //Player being promoted
        $currentTeam = $playerToPromote->team; //Original team of player
        $manager = Auth::user(); //Logged in manager
        $teamToPromoteTo = $manager->manager->team; //Team to promote to (current team)

        //Create Promotion model for record of promotion for future demotion
        $promotion = new Promotion();
        $promotion->user_id = $playerToPromote->user->id;
        $promotion->original_team = $currentTeam->teamId;
        $promotion->promoted_team = $teamToPromoteTo->teamId;
        $promotion->save();

        //Change team associated with player
        $playerToPromote->teamId = $teamToPromoteTo->teamId;
        $playerToPromote->save();

        return redirect(route("squadStatistics"));
    }

    /**
     * Function to demote a promoted player back to their original squad
     * @param $promotionId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function demotePlayer($promotionId) {
        $promotion = Promotion::find($promotionId);
        $playerToChange = $promotion->user->player;

        $playerToChange->teamId = $promotion->originalTeam->teamId;
        $playerToChange->save();

        $promotion->delete();

        return redirect(route("squadStatistics"));
    }

    /**
     * Function to get players already promoted from younger squads
     * @return Promotion[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getPromotedPlayers() {
        $teamToCheck = Auth::user()->manager->team;
        $promotions = Promotion::all()->where("promoted_team", $teamToCheck->teamId);

        return $promotions;
    }
}
