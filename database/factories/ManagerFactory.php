<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Manager;
use App\User;
use Faker\Generator as Faker;

$factory->define(Manager::class, function (Faker $faker) {
    $userAccount = User::all()->where("accountType", "M")->random(1)->first();
    $userName = explode(" ", $userAccount->name);
    return [
        'userId' => $userAccount->id,
        'firstName' => $userName[0],
        'lastName' => $userName[1],

    ];
});
