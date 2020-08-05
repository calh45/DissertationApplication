<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{


    public function user() {
        return $this -> belongsTo("App\User", "userId", "id");
    }

    public function team() {
        return $this -> belongsTo("App\Team", "id", "managerId");
    }
}
