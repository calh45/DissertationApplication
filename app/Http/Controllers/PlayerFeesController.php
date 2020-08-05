<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerFeesController extends Controller
{
    /**
     * Display View allowing a player to pay fees to screen and Manager to view all previous transactions
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id) {
        $thisUser = User::all()->where("id", $id)->first(); //Currently logged in User
        $transactions = Transaction::all()->where("user_id", $thisUser->id); //Previous Transactions of User

        return view("playerFees", ["thisUser" => $thisUser, "transactions" => $transactions]);
    }

    /**
     * Function to process the paying of a Player fee
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function payFee(Request $request) {
        $loggedInUser = Auth::user(); //Currently logged in User who is paying fee

        $playerToUse = $loggedInUser->player; //Player model of logged in User
        $currentBalance = $playerToUse->balance; //Current Balance of Player
        $newBalance = $currentBalance + (double)request("amountToPay"); //New balance after payment is applied

        //Update value in Player model
        $playerToUse->balance = $newBalance;
        $playerToUse->save();

        //Create Transaction model for payment
        $newTransaction = new Transaction();
        $newTransaction->transaction_type = "Payment";
        $newTransaction->user_id = $loggedInUser->id;
        $newTransaction->amount = (double)request("amountToPay");
        $newTransaction->save();

        return redirect("/playerFees/$loggedInUser->id");
    }

    /**
     * Function allowing a Manager to send a reminder to a Player when they are behind on fees
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendReminder($id) {
        //Create Notification
        NotificationsController::create($id, "Finance",
            "Your manager has reminded you that you are behind on your fees");

        return redirect("/playerFees/$id");
    }


}
