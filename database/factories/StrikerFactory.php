<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Player;
use App\Striker;
use Faker\Generator as Faker;

$factory->define(Striker::class, function (Faker $faker) {
    $playerToUse = Player::all()->where("position", "FW")->random(1)->first();
    return [
        "playerId" => $playerToUse->id,
        "chancesCreated" => $faker->numberBetween($min=0, $max=30),
        "shots" => $faker->numberBetween($min=30, $max=40),
        "shotsOnTarget" => $faker->numberBetween($min=20, $max=29),
        "headedGoals" => $faker->numberBetween($min=0, $max=15),
        "penaltiesTaken" => $faker->numberBetween($min=8, $max=10),
        "penaltiesScored" => $faker->numberBetween($min=0, $max=8),
        "goalsScore" => 0,
        "assistsScore" => 0,
        "shotsOnTargetScore" => 0,
        "chancesCreatedScore" => 0,
        "penaltiesScore" => 0,
        "totalScore" => 0,
    ];
});
