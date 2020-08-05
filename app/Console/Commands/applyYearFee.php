<?php

namespace App\Console\Commands;

use App\Http\Controllers\NotificationsController;
use App\Notification;
use App\Player;
use App\Team;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Symfony\Component\VarDumper\Cloner\Data;

class applyYearFee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apply:fee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apply yearly fees to players' ;

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
        $allTeams = Team::all(); //Initialise all teams to check
        $todayMonth = Carbon::now()->month;
        $todayDay = Carbon::now()->day;

        //Loop through each team and check their subscription fee date with the current date and apply fee to each player
        //if dates match
        foreach($allTeams as $currentTeam) {
            //Initialise date components of team
            $dateToCheck = $currentTeam->subscriptionDate;
            $monthToCheck = Carbon::createFromFormat('Y-m-d H:i:s', $dateToCheck)->month;
            $dayToCheck = Carbon::createFromFormat('Y-m-d H:i:s', $dateToCheck)->day;

            //If dates match, apply fee to each Player account
            if($todayMonth == $monthToCheck && $todayDay == $dayToCheck) {
                $allPlayers = Player::all()->where("teamId", $currentTeam->teamId);

                //Loop through each Player account and apply fee
                foreach($allPlayers as $currentPlayer) {
                    //Calculate new balance for player account
                    $currentBalance = $currentPlayer->balance;
                    $newBalance = $currentBalance - $currentTeam->subscription;

                    //Set new balance
                    $currentPlayer->balance = $newBalance;
                    $currentPlayer->save();

                    //Create Transaction model
                    $newTransaction = new Transaction();
                    $newTransaction->transaction_type = "Fee";
                    $newTransaction->user_id = $currentPlayer->user->id;
                    $newTransaction->amount = -($currentTeam->subscription);
                    $newTransaction->save();

                    //Create Notification
                    NotificationsController::create($currentPlayer->user->id, "Finance",
                        "Your yearly subscription fee has been taken from your account");
                }
            }
        }
    }
}
