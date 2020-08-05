<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Striker extends Model
{
    public function player() {
        return $this -> belongsTo("App\Player", "playerId", "id");
    }
}
