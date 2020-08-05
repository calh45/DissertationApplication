<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'accountType', 'name', 'email', 'password', 'profileImage',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function manager() {
        return $this -> hasOne("App\Manager", "userId", "id");
    }

    public function player() {
        return $this -> hasOne("App\Player", "userId", "id");
    }

    public function promotion() {
        return $this -> hasOne("App\Promotion", "user_id", "id");
    }

    public function notifications() {
        return $this -> hasMany("App\Notification", "user_id", "id");
    }

    public function transactions() {
        return $this -> hasMany("App\Transaction", "user_id", "id");
    }

    public function availabilities() {
        return $this -> hasMany("App\Transaction", "user_id", "id");
    }
}
