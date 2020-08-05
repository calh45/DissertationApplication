<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class NotificationsController extends Controller
{
    /**
     * Screen showing all of a players notifications
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        //User logged in
        $subjectUser = Auth::user();
        $notificationsToSend = $subjectUser->notifications; //Notifications of user logged in

        //Update all previously unseen notifications to seen
        DB::table("notifications")->where("user_id", $subjectUser->id)->update(["seen" => 1]);

        return view("notifications", ["thisNotifications" => $notificationsToSend]);
    }

    /**
     * Function to create a notification
     * @param $userId
     * @param $type
     * @param $content
     */
    public static function create($userId, $type, $content) {
        $toSave = new Notification();
        $toSave->user_id = $userId;
        $toSave->type = $type;
        $toSave->content = $content;
        $toSave->seen = 0;
        $toSave->save();

    }

}
