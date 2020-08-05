<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    public function teams() {
        return $this -> hasMany("App\Team", "clubId", "id");
    }

    public function players() {
        return $this -> hasMany("App\Player", "clubId", "id");
    }
}
