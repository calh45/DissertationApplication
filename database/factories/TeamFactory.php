<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Club;
use App\Manager;
use App\Team;
use Faker\Generator as Faker;

$factory->define(Team::class, function (Faker $faker) {
    $teamManager = Manager::all()->random(1)->first();
    return [
        "clubId" => Club::all()->random(1)->first(),
        "teamName" => $faker->randomElement(["under9", "under10", "under15", "under16"]),
        "managerId" => null,
        "managerEmail" => "calvinhothi@yahoo.co.uk",
        "subscription" => 00.00,
        "subscriptionDate" => \Illuminate\Support\Carbon::now(),

    ];
});
