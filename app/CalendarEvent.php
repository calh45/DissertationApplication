<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    public function getDates() {
        return array('created_at', 'updated_at');
    }

    public function team() {
        return $this -> belongsTo("App\Team", "team_id", "teamId");
    }

    public function availabilities()
    {
        return $this -> hasMany("App\Availability", "id", "event_id");
    }

    public function lineup() {
        return $this -> hasOne("App\Lineup", "id", "event_id");
    }

    public function matchStatistic() {
        return $this -> hasOne("App\MatchStatistics", "id", "event_id");
    }
}
