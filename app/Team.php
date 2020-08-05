<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $primaryKey = "teamId";

    protected $fillable = [
        'managerId'
    ];

    public function club() {
        return $this -> belongsTo("App\Club", "clubId", "id");
    }

    public function manager() {
        return $this -> hasOne("App\Manager", "managerId", "id");
    }

    public function players() {
        return $this -> hasMany("App\Player", "teamId", "teamId");
    }

    public function calendarEvents() {
        return $this -> hasMany("App\CalendarEvent", "teamId", "team_id");
    }
}
