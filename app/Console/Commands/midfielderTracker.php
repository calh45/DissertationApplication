<?php

namespace App\Console\Commands;

use App\Midfielder;
use Illuminate\Console\Command;

class midfielderTracker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'midfielder:track';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $midfielders = Midfielder::all(); //All midfielder models

        //Loop over each Midfielder model and analyse their overall, attacking and defensive scores
        foreach($midfielders as $midfielder) {
            //Calculate Total Score for a Midfielder
            $newGoalContribution = $this->goalContributionScore($midfielder, 20); //Goals + Assists per game ratio
            $newTackles = $this->tacklesScore($midfielder, 20); //Successful Tackles ratio
            $newDribbles = $this->dribblesScore($midfielder, 20); //Successful Dribbles ratio per game
            $newChancesCreated = $this->chancesCreatedScore($midfielder, 15); //Chances Created per game
            $newShotsOnTarget = $this->shotsOnTargetScore($midfielder, 10); //Shots on target per game
            $newPasses = $this->passesScore($midfielder, 15); //Successful Passes ratio

            $totalScore = $newGoalContribution + $newTackles + $newDribbles + $newChancesCreated + $newShotsOnTarget +
                $newPasses;

            //Calculate Score for Defensive Midfielder
            $defTackles = $this->tacklesScore($midfielder, 50); //Successful Tackles ratio
            $defDribbles = $this->dribblesScore($midfielder, 10); //Successful Dribbles ratio per game
            $defPasses = $this->passesScore($midfielder, 10); //Successful Passes ratio
            $defFouls = $this->foulsScore($midfielder, 20); //Fouls per game ration
            $defCards = $this->cardsScore($midfielder, 10); //Red + Yellow Cards per game ratio

            $defScore = $defTackles + $defDribbles + $defPasses + $defFouls + $defCards;

            //Calculate Score for Attacking Midfielder
            $attGoalContribution = $this->goalContributionScore($midfielder, 30); //Goals + Assists per game ratio
            $attDribbles = $this->dribblesScore($midfielder, 20); //Successful Dribbles ratio per game
            $attChancesCreated = $this->chancesCreatedScore($midfielder, 20); //Chances Created per game
            $attShotsOnTarget = $this->shotsOnTargetScore($midfielder, 10); //Shots on target per game
            $attPasses = $this->passesScore($midfielder, 20); //Successful Passes ratio

            $attScore = $attGoalContribution + $attDribbles + $attChancesCreated + $attShotsOnTarget + $attPasses;

            //Update Midfielder model in database
            $midfielder->goalContributionScore = $newGoalContribution;
            $midfielder->tacklesScore = $newTackles;
            $midfielder->dribblesScore = $newDribbles;
            $midfielder->chancesCreatedScore = $newChancesCreated;
            $midfielder->shotTargetScore = $newShotsOnTarget;
            $midfielder->passesScore = $newPasses;
            $midfielder->foulsScore = $defFouls;
            $midfielder->cardsScore = $defCards;
            $midfielder->totalScore = $totalScore;
            $midfielder->defScore = $defScore;
            $midfielder->attScore = $attScore;
            $midfielder->save();

            //Update total score in midfielders relevant Player model
            $playerAccount = $midfielder->player;
            $playerAccount->totalScore = $midfielder->totalScore;
            $playerAccount->save();
        }
    }

    /**
     * Function to calculate Goal Contribution score (number of goals + assists / number of appearances) * weighting
     * @param $defender
     * @return float|int
     */
    public function goalContributionScore($player, $weighting) {
        $score = (($player->player->goals) + ($player->player->assists)) / $player->player->appearances;

        if($score <= 0.2) {
            return 0.2 * $weighting;
        } elseif($score <= 0.4) {
            return 0.4 * $weighting;
        } elseif($score <= 0.6) {
            return 0.6 * $weighting;
        } elseif($score <= 0.8) {
            return 0.8 * $weighting;
        } else {
            return $weighting;
        }
    }

    /**
     * Function to calculate Tackles score (number of tackles won / number of tackles attempted) * weighting
     * @param $defender
     * @return float|int
     */
    public function tacklesScore($player, $weighting) {
        $score = $player->tacklesWon / $player->tacklesAttempted;

        return $score * $weighting;
    }

    /**
     * Function to calculate Dribbles score (number of successful dribbles / number of dribbles attempted) * weighting
     * @param $defender
     * @return float|int
     */
    public function dribblesScore($player, $weighting) {
        $score = $player->successfullDribbles / $player->dribblesAttempted;

        return $score * $weighting;
    }

    /**
     * Function to calculate Chances Created score
     * @param $defender
     * @return float|int
     */
    public function chancesCreatedScore($player, $weighting) {
        $score = $player->chancesCreated / $player->player->appearances;

        if($score <= 0.5) {
            return 0.2 * $weighting;
        } elseif($score <= 2) {
            return 0.5 * $weighting;
        } elseif ($score <= 5) {
            return 0.8 * $weighting;
        } else {
            return $weighting;
        }
    }

    /**
     * Function to calculate Shots on Target score (number of shots on target / number of shots) * weighting
     * @param $defender
     * @return float|int
     */
    public function shotsOnTargetScore($player, $weighting) {
        $score = $player->shotsOnTarget / $player->shots;

        return $score * $weighting;
    }

    /**
     * Function to calculate Passes score (number of clean sheets / number of appearances) * weighting
     * @param $defender
     * @return float|int
     */
    public function passesScore($player, $weighting) {
        $score = $player->player->passesCompleted / $player->player->passesAttempted;

        return $score * $weighting;
    }

    /**
     * Function to calculate Cards score
     * @param $defender
     * @return float|int
     */
    public function cardsScore($player, $weighting) {
        $score = ($player->player->yellowCards + $player->player->redCards) / $player->player->appearances;

        if($score <= 0.2) {
            return $weighting;
        } elseif($score <= 0.4) {
            return 0.8 * $weighting;
        } elseif($score <= 0.6) {
            return 0.6 * $weighting;
        } elseif($score <= 0.8) {
            return 0.4 * $weighting;
        } else {
            return 0.2 * $weighting;
        }
    }

    /**
     * Function to calculate Fouls score
     * @param $defender
     * @return float|int
     */
    public function foulsScore($player, $weighting) {
        $score = $player->player->fouls / $player->player->appearances;

        if($score <= 1) {
            return $weighting;
        } elseif($score <= 3) {
            return 0.8 * $weighting;
        } elseif($score <= 5) {
            return 0.6 * $weighting;
        } elseif($score <= 7) {
            return 0.4 * $weighting;
        } else {
            return 0.2 * $weighting;
        }

    }
}
