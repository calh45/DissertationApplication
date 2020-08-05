<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function club() {
        return $this -> belongsTo("App\Club", "clubId", "id");
    }

    public function team() {
        return $this -> belongsTo("App\Team", "teamId", "teamId");
    }

    public function user() {
        return $this -> belongsTo("App\User", "userId", "id");
    }

    public function goalkeeper() {
        return $this->hasOne("App\Goalkeeper", "playerId", "id");
    }

    public function defender() {
        return $this->hasOne("App\Defender", "playerId", "id");
    }

    public function midfielder() {
        return $this->hasOne("App\Midfielder", "playerId", "id");
    }

    public function striker() {
        return $this->hasOne("App\Striker", "playerId", "id");
    }

    public function targets() {
        return $this -> hasMany("App\Target", "user_id", "id");
    }

}
