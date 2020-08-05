<?php

namespace App\Http\Middleware;

use App\Defender;
use App\Goalkeeper;
use App\Manager;
use App\Midfielder;
use App\Player;
use App\Striker;
use App\Team;
use App\User;
use Closure;
use Illuminate\Support\Facades\App;


class PlayerCreate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $userAccount = User::all()->where("email", $request["playerEmail"])->first();
        $teamToUse = Team::all()->where("teamId", $request["playerTeamId"])->first();

        $playerToAdd = new Player();
        $playerToAdd->userId = $userAccount->id;
        $playerToAdd->clubId = $teamToUse->club->id;
        $playerToAdd->teamId = $teamToUse->teamId;
        $playerToAdd->position = $request["playerPosition"];
        $playerToAdd->age = (int)$request["playerAge"];
        $playerToAdd->balance = 00.00;
        $playerToAdd->appearances = 0;
        $playerToAdd->yellowCards = 0;
        $playerToAdd->redCards = 0;
        $playerToAdd->goals = 0;
        $playerToAdd->assists = 0;
        $playerToAdd->passesAttempted = 0;
        $playerToAdd->passesCompleted = 0;
        $playerToAdd->fouls = 0;
        $playerToAdd->totalScore = 0;
        $playerToAdd->technical = "";
        $playerToAdd->psychological = "";
        $playerToAdd->physical = "";
        $playerToAdd->social = 0;

        $playerToAdd->save();


        $toCheck = $request['playerPosition'];

        if($request['playerPosition'] == "GK") {
            $goalkeeperToAdd = new Goalkeeper();
            $goalkeeperToAdd->playerId = $playerToAdd->id;
            $goalkeeperToAdd->cleanSheets = 0;
            $goalkeeperToAdd->shotsFaced = 0;
            $goalkeeperToAdd->shotsSaved = 0;
            $goalkeeperToAdd->pensFaced = 0;
            $goalkeeperToAdd->pensSaved = 0;
            $goalkeeperToAdd->pensGivenAway = 0;
            $goalkeeperToAdd->crossesClaimed = 0;
            $goalkeeperToAdd->csScore = 0;
            $goalkeeperToAdd->saveScore = 0;
            $goalkeeperToAdd->penSaveScore = 0;
            $goalkeeperToAdd->crossScore = 0;
            $goalkeeperToAdd->ballPlayScore = 0;
            $goalkeeperToAdd->commandBoxScore = 0;
            $goalkeeperToAdd->totalScore = 0;
            $goalkeeperToAdd->save();

        } elseif ($request['playerPosition'] == "DF") {
            $defenderToAdd = new Defender();
            $defenderToAdd->playerId = $playerToAdd->id;
            $defenderToAdd->cleanSheets = 0;
            $defenderToAdd->aerialDuelsWon = 0;
            $defenderToAdd->aerialDuelsLost = 0;
            $defenderToAdd->tacklesAttempted = 0;
            $defenderToAdd->tacklesWon = 0;
            $defenderToAdd->shotsBlocked = 0;
            $defenderToAdd->pensGivenAway = 0;
            $defenderToAdd->csScore = 0;
            $defenderToAdd->aerialDuelScore = 0;
            $defenderToAdd->tackleScore = 0;
            $defenderToAdd->shotBlockedScore = 0;
            $defenderToAdd->pensGivenScore = 0;
            $defenderToAdd->foulsScore = 0;
            $defenderToAdd->totalScore = 0;
            $defenderToAdd->ballPlayScore = 0;
            $defenderToAdd->attackingThreatScore = 0;
            $defenderToAdd->save();

        } elseif ($request['playerPosition'] == "MF") {
            $midfielderToAdd = new Midfielder();
            $midfielderToAdd->playerId = $playerToAdd->id;
            $midfielderToAdd->tacklesAttempted = 0;
            $midfielderToAdd->tacklesWon = 0;
            $midfielderToAdd->dribblesAttempted = 0;
            $midfielderToAdd->successfullDribbles = 0;
            $midfielderToAdd->chancesCreated = 0;
            $midfielderToAdd->shots = 0;
            $midfielderToAdd->shotsOnTarget = 0;
            $midfielderToAdd->goalContributionScore = 0;
            $midfielderToAdd->tacklesScore = 0;
            $midfielderToAdd->dribblesScore = 0;
            $midfielderToAdd->chancesCreatedScore = 0;
            $midfielderToAdd->shotTargetScore = 0;
            $midfielderToAdd->passesScore = 0;
            $midfielderToAdd->foulsScore = 0;
            $midfielderToAdd->cardsScore = 0;
            $midfielderToAdd->totalScore = 0;
            $midfielderToAdd->defScore = 0;
            $midfielderToAdd->attScore = 0;
            $midfielderToAdd->save();

        } else {
            $strikerToAdd = new Striker();
            $strikerToAdd->playerId = $playerToAdd->id;
            $strikerToAdd->chancesCreated= 0;
            $strikerToAdd->shots = 0;
            $strikerToAdd->shotsOnTarget = 0;
            $strikerToAdd->headedGoals = 0;
            $strikerToAdd->penaltiesTaken = 0;
            $strikerToAdd->penaltiesScored = 0;
            $strikerToAdd->goalsScore = 0;
            $strikerToAdd->assistsScore = 0;
            $strikerToAdd->shotsOnTargetScore = 0;
            $strikerToAdd->chancesCreatedScore = 0;
            $strikerToAdd->penaltiesScore = 0;
            $strikerToAdd->totalScore = 0;
            $strikerToAdd->save();
        }

        return $response;
    }


}
