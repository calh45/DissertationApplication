<?php

namespace App\Console\Commands;

use App\Striker;
use Illuminate\Console\Command;

class forwardTracker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forward:track';

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
        $forwards = Striker::all(); //All Forward Models

        //Loop through each Forward model and apply statistical analysis algorithm
        foreach($forwards as $forward) {
            $newGoalsScore = $this->goalsScore($forward); //Goals per game
            $newAssistsScore = $this->assistsScore($forward); //Assists per game
            $newShotsScore = $this->shotsOnTargetScore($forward); //Shots on target ratio
            $newChancesCreated = $this->chancesCreatedScore($forward); //Chances created per game
            $newPenaltiesScore = $this->penaltiesScore($forward); //Penalties scored ratio

            //Calculate Total score
            $newTotalScore = $newGoalsScore + $newAssistsScore + $newShotsScore + $newChancesCreated + $newPenaltiesScore;

            //Update Forward model database
            $forward->goalsScore = $newGoalsScore;
            $forward->assistsScore = $newAssistsScore;
            $forward->chancesCreatedScore = $newChancesCreated;
            $forward->penaltiesScore = $newPenaltiesScore;
            $forward->totalScore = $newTotalScore;
            $forward->save();

            //Update Total Score in Forwards relevant Player model
            $playerAccount = $forward->player;
            $playerAccount->totalScore = $forward->totalScore;
            $playerAccount->save();
        }
    }

    /**
     * Function to calculate Goals score
     * @param $defender
     * @return float|int
     */
    public function goalsScore($player) {
        $weighting = 60;
        $score = $player->player->goals / $player->player->appearances;

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
     * Function to calculate Assists score
     * @param $defender
     * @return float|int
     */
    public function assistsScore($player) {
        $weighting = 10;
        $score = $player->player->assists / $player->player->appearances;

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
     * Function to calculate Shots On Target score
     * @param $defender
     * @return float|int
     */
    public function shotsOnTargetScore($player) {
        $weighting = 10;

        return ($player->shotsOnTarget / $player->shots) * $weighting;
    }

    /**
     * Function to calculate Chances Created score
     * @param $defender
     * @return float|int
     */
    public function chancesCreatedScore($player) {
        $weighting = 10;
        $score = $player->chancesCreated / $player->player->appearances;

        if($score <= 0.5) {
            return 0.2 * $weighting;
        } elseif($score <= 2) {
            return 0.4 * $weighting;
        } elseif($score <= 5) {
            return 0.6 * $weighting;
        } elseif($score <= 7) {
            return 0.8 * $weighting;
        } else {
            return $weighting;
        }

    }

    /**
     * Function to calculate Penalties score
     * @param $defender
     * @return float|int
     */
    public function penaltiesScore($player) {
        $weighting = 10;

        return ($player->penaltiesScore / $player->penaltiesTaken) * $weighting;
    }
}
