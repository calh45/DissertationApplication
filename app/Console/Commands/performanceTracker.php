<?php

namespace App\Console\Commands;

use App\Goalkeeper;
use Illuminate\Console\Command;

class performanceTracker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'goalkeeper:track';

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
        $goalkeepers = Goalkeeper::all(); //Collect all Goalkeeper models

        //Loop over each Goalkeeper and perform analysis
        foreach ($goalkeepers as $goalkeeper) {
            $newCsScore = $this->csScore($goalkeeper); //Collect Clean Sheet score
            $newSaveScore = $this->saveScore($goalkeeper); //Collect Save score (successful saves ratio)
            $newPenSaveScore = $this->penSaveScore($goalkeeper); //Collect Penalty Save score (successful penalties saved ratio)
            $newCrossScore = $this->crossClaimedCalculator($goalkeeper); //Collect Crosses Claimed score (successful cross claimed)

            //Collect scores for additionally tracked abilities that do not contribute to total score
            $ballPlayerScore = ($goalkeeper->player->passesCompleted / $goalkeeper->player->passesAttempted) * 100;
            $commandingBoxScore = $goalkeeper->crossesClaimed / $goalkeeper->player->appearances;

            //Update stored scores in database
            $goalkeeper->csScore = $newCsScore;
            $goalkeeper->saveScore = $newSaveScore;
            $goalkeeper->penSaveScore = $newPenSaveScore;
            $goalkeeper->crossScore = $newCrossScore;
            $goalkeeper->totalScore = $newCsScore + $newSaveScore + $newPenSaveScore + $newCrossScore;
            $goalkeeper->ballPlayScore = $ballPlayerScore;
            $goalkeeper->commandBoxScore = $commandingBoxScore;

            $goalkeeper->save();

            //Update total score in relevant Player Model
            $playerAccount = $goalkeeper->player;
            $playerAccount->totalScore = $goalkeeper->totalScore;
            $playerAccount->save();
        }
    }

    /**
     * Function to calculate a Goalkeepers Clean Sheet score (number of clean sheets / appearances) * weighting
     * @param $goalkeeper
     * @return float|int
     */
    public function csScore($goalkeeper) {
        //Percentage of total score that this component is worth
        $weighting = 35;

        return (($goalkeeper->cleanSheets / $goalkeeper->player->appearances)) * $weighting;
    }

    /**
     * Function to calculate a Goalkeepers Save score (number of successful saves / shots faced) * weighting
     * @param $goalkeeper
     * @return float|int
     */
    public function saveScore($goalkeeper) {
        //Percentage of total score that this component is worth
        $weighting = 35;

        return (($goalkeeper->shotsSaved / $goalkeeper->shotsFaced)) * $weighting;
    }

    /**
     * Function to calculate a Goalkeepers Penalty Save score (number of penalties saved / number of penalties faced) *
     * weighting
     * @param $goalkeeper
     * @return float|int
     */
    public function penSaveScore($goalkeeper) {
        //Percentage of total score this component is worth
        $weighting = 10;

        return (($goalkeeper->pensSaved / $goalkeeper->pensFaced)) * $weighting;
    }

    /**
     * Function to calculate a Goalkeepers Crosses Claimed score
     * @param $goalkeeper
     * @return float|int
     */
    public function crossClaimedCalculator($goalkeeper) {
        $weighting = 20;
        $score = ($goalkeeper->crossesClaimed / $goalkeeper->player->appearances);

        if ($score <= 0) {
            return 0.2 * $weighting;
        } elseif ($score <= 2) {
            return 0.4 * $weighting;
        } elseif ($score <= 5) {
            return 0.6 * $weighting;
        } elseif ($score <= 8) {
            return 0.8 * $weighting;
        } else {
            return 1 * $weighting;
        }
    }
}
