<?php

namespace App\Console\Commands;

use App\Http\Controllers\NotificationsController;
use App\Notification;
use App\Team;
use Carbon\Carbon;
use Illuminate\Console\Command;

class feeWeekNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fee:preNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to players a week before fee is due';

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
     * Create notification for each player account in teams who's subscription date is one week away
     *
     * @return mixed
     */
    public function handle()
    {
        $allTeams = Team::all(); //Initialise all teams to check
        $todayDate = Carbon::now(); //Todays date

        //Loop over each team
        foreach($allTeams as $team) {
            $subDate = $team->subscriptionDate; //Teams subscription fee date

            $difference = $todayDate->diff($subDate); //Difference in time between current date and subscription date
            //If the difference is 6 days (1 week) in advance, generate notification
            if($difference->days == 6) {
                $allPlayers = $team->players;

                //Loop over each player in team and create notification
                foreach($allPlayers as $player) {
                    NotificationsController::create($player->user->id, "Finance",
                        "Your yearly subscription fee will be taken in 1 weeks time");

                }
            }

        }
    }
}
