<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    public function user() {
        return $this->belongsTo("App\User", "user_id", "id");
    }

    public function promotedTeam() {
        return $this->belongsTo("App\Team", "promoted_team", "teamId");
    }

    public function originalTeam() {
        return $this->belongsTo("App\Team", "original_team", "teamId");
    }
}
