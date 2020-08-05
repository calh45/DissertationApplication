<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchStatistics extends Model
{
    public function calendarEvent() {
        return $this -> belongsTo("App/CalendarEvent", "event_id", "id");
    }
}
