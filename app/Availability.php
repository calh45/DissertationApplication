<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    public function user() {
        return $this -> belongsTo("App\User", "user_id", "id");
    }

    public function calendarEvent() {
        return $this -> belongsTo("App\CalendarEvent", "event_id", "id");
    }
}
