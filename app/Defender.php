<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Defender extends Model
{
    public function player() {
        return $this -> belongsTo("App\Player", "playerId", "id");
    }
}
