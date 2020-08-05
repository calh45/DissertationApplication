<?php

namespace App\Console\Commands;

use App\Defender;
use Illuminate\Console\Command;

class defenderTracker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'defender:tracker';

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
    public function handle() {
        $defenders = Defender::all(); //All defender models

        //Loop through each Defender model and perform analysis algorithms on statistics
        foreach ($defenders as $defender) {
            $newCsScore = $this->csScore($defender); //Collect Clean Sheet score
            $newAerialDuelScore = $this->aerialDuelsScore($defender); //Collect Aerial Duel score
            $newTackleScore = $this->tacklesScore($defender); //Collect Tackle score
            $newShotBlockedScore = $this->shotBlockedScore($defender); //Collect Shot Blocked score
            $newPensGivenScore = $this->pensGivenScore($defender); //Collect Penalties given away score
            $newFoulsScore = $this->foulsScore($defender); //Collect Fouls score

            //Calculate scores for additionally tracked abilities that do not contribute to total score
            $ballPlayingDefender = ($defender->player->passesCompleted / $defender->player->passesAttempted) * 100;
            $attackingThreat = $this->attackingThreat($defender);

            //Update scores in database for Defender model
            $defender->csScore = $newCsScore;
            $defender->aerialDuelScore = $newAerialDuelScore;
            $defender->tackleScore = $newTackleScore;
            $defender->shotBlockedScore = $newShotBlockedScore;
            $defender->pensGivenScore = $newPensGivenScore;
            $defender->foulsScore = $newFoulsScore;
            $defender->totalScore = $newCsScore + $newAerialDuelScore + $newTackleScore + $newShotBlockedScore +
                $newPensGivenScore + $newFoulsScore;
            $defender->ballPlayScore = $ballPlayingDefender;
            $defender->attackingThreatScore = $attackingThreat;
            $defender->save();

            //Update Total Score in database for related Player model
            $playerAccount = $defender->player;
            $playerAccount->totalScore = $defender->totalScore;
            $playerAccount->save();

        }
    }

    /**
     * Function to calculate Clean Sheet score (number of clean sheets / number of appearances) * weighting
     * @param $defender
     * @return float|int
     */
    public function csScore($defender) {
        //Percentage of total score this component is worth
        $weighting = 20;

        return ($defender->cleanSheets / $defender->player->appearances) * $weighting;
    }

    /**
     * Function to calculate Aerial Duel score (number of aerial duels won / total number of aerial duels) * weighting
     * @param $defender
     * @return float|int
     */
    public function aerialDuelsScore($defender) {
        //Percentage of total score this component is worth
        $weighting = 30;

        return (($defender->aerialDuelsWon)/($defender->aerialDuelsWon + $defender->aerialDuelsLost)) * $weighting;
    }

    /**
     * Function to calculate Tackles score (number of successful tackles / number of attempted tackles) * weighting
     * @param $defender
     * @return float|int
     */
    public function tacklesScore($defender) {
        //Percentage of total score this component is worth
        $weighting = 30;

        return (($defender->tacklesWon)/($defender->tacklesAttempted)) * $weighting;
    }

    /**
     * Function to calculate Shots Blocked score
     * @param $defender
     * @return float|int
     */
    public function shotBlockedScore($defender) {
        //Percentage of total score this component is worth
        $weighting = 10;

        $shotsBlocked = $defender->shotsBlocked / $defender->player->appearances;

        if($shotsBlocked <= 0) {
            return 0.2 * $weighting;
        } elseif($shotsBlocked <= 3) {
            return 0.4 * $weighting;
        } elseif($shotsBlocked <= 6) {
            return 0.6 * $weighting;
        } else {
            return $weighting;
        }
    }

    /**
     * Function to calculate Penalties Given Away score
     * @param $defender
     * @return float|int
     */
    public function pensGivenScore($defender) {
        //Percentage of total score this component is worth
        $weighting = 5;

        $pens = $defender->pensGivenAway / $defender->player->appearances;

        if($pens <= 0.2) {
            return 1 * $weighting;
        } elseif($pens <= 0.4) {
            return 0.8 * $weighting;
        } elseif($pens <= 0.6) {
            return 0.6 * $weighting;
        } elseif($pens <= 0.8) {
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
    public function foulsScore($defender) {
        //Percentage of total score this component is worth
        $weighting = 5;

        $fouls = $defender->fouls / $defender->player->appearances;

        if($fouls <= 0) {
            return 1 * $weighting;
        } elseif($fouls <= 2) {
            return 0.8 * $weighting;
        } elseif($fouls <= 5) {
            return 0.6 * $weighting;
        } elseif($fouls <= 8) {
            return 0.4 * $weighting;
        } else {
            return 0.2 * $weighting;
        }
    }

    /**
     * Function to calculate Attacking Threat score
     * @param $defender
     * @return float|int
     */
    public function attackingThreat($defender) {
        //Not related to total score, this is its own weighting set
        $weighting = 100;

        $goalScore = $defender->player->goals / $defender->player->appearances;

        if($goalScore <= 0.2) {
            return 0.2 * $weighting;
        } elseif($goalScore <= 0.4) {
            return 0.4 * $weighting;
        } elseif($goalScore <= 0.6) {
            return 0.6 * $weighting;
        } elseif($goalScore <= 0.8) {
            return 0.8 * $weighting;
        } else {
            return 1 * $weighting;
        }
    }

}
