<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lineup extends Model
{
    public function calendar_event() {
        return $this -> belongsTo("App\CalendarEvent", "event_id", "id");
    }
}
