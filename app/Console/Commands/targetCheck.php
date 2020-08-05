<?php

namespace App\Console\Commands;

use App\Http\Controllers\NotificationsController;
use App\Target;
use Carbon\Carbon;
use Illuminate\Console\Command;

class targetCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'target:check';

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
        //Collect records of any Targets with end dates equal to the current date
        $targetsToCheck = Target::all()->where("end_date", "==",  date("Y-m-d"));

        //Loop through each target and carry out analysis on if target was completed
        foreach ($targetsToCheck as $currentTarget) {
            //Initialise relevant start, current and target scores
            $startScore = $currentTarget->start_score;
            $currentScore = $currentTarget->current_score;
            $targetScore = $currentTarget->target_score;

            //Difference between the players current score and targeted score
            $difference = $currentScore - $targetScore;


            if($currentScore >= $targetScore) {
                //If target has been achieved

                $reportToSave = "Target completed within timescale.";

                //Calculate rate of success
                if($difference > ($targetScore * 10)) {
                    //If difference in players current score and target score is larger than 10% of target score

                    $reportToSave = $reportToSave." The player actually showed levels of improvement above what was tasked. 
                    Development in this area is sufficient enough to end this target. ";
                } else {
                    $reportToSave = $reportToSave." The player achieved this target but only minimally. It may be worth 
                    monitoring the progress of the player in this field for the coming weeks. ";
                }
            } else if ($currentScore < $startScore) {
                //If player has made negative progress on target

                $reportToSave = "Player's ability in this area actually regressed during this target. This may be due to 
                the player not being suited for this position. It is not advised to continue training this position unless 
                you are certain. ";
            } else {
                //If player has not achieved target but made positive progress

                $reportToSave = "Target not completed.";

                //Calculate rate of progress
                if($currentScore >= (($targetScore+$startScore)/2)) {
                    //If players current score is larger than half way point between start score and target score

                    $reportToSave = $reportToSave." However decent progress was made in this area. Recommended to continue 
                    this target for another session in hopes that player will reach intended target. ";
                } else {
                    $reportToSave = $reportToSave." Poor progress within desired target. This could be down to players 
                    individual strengths or suitability to their current position. ";
                }
            }

            //Save report
            $currentTarget->report = $reportToSave;
            $currentTarget->save();

            NotificationsController::create($currentTarget->user->user->id, "Target",
                $currentTarget->target_name." has finished, view report in targets tab");
        }


    }
}
