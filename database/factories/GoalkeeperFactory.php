<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Goalkeeper;
use App\Player;
use Faker\Generator as Faker;

$factory->define(Goalkeeper::class, function (Faker $faker) {
    $playerToUse = Player::all()->where("position", "GK")->random(1)->first();
    return [
        "playerId" => $playerToUse->id,
        "cleanSheets" => $faker->numberBetween($min=0, $max=$playerToUse->appearances),
        "shotsFaced" => $faker->numberBetween($min=100, $max=200),
        "shotsSaved" => $faker->numberBetween($min=0, $max=99),
        "pensFaced" => $faker->numberBetween($min=30, $max=40),
        "pensSaved" => $faker->numberBetween($min=0, $max=29),
        "pensGivenAway" => $faker->numberBetween($min=30, $max=40),
        "crossesClaimed" => $faker->numberBetween($min=0, $max=100),
        "csScore" => $faker->numberBetween($min=0, $max=35),
        "saveScore" => $faker->numberBetween($min=0, $max=35),
        "penSaveScore" => $faker->numberBetween($min=0, $max=10),
        "crossScore" => $faker->numberBetween($min=0, $max=20),
        "totalScore" => $faker->numberBetween($min=0, $max=100),
        "ballPlayScore" => $faker->numberBetween($min=0, $max=100),
        "commandBoxScore" => $faker->numberBetween($min=0, $max=10),
    ];
});
