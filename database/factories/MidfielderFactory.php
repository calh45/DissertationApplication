<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Midfielder;
use App\Player;
use Faker\Generator as Faker;

$factory->define(Midfielder::class, function (Faker $faker) {
    $playerToUse = Player::all()->where("position", "MF")->random(1)->first();
    return [
        "playerId" => $playerToUse->id,
        "tacklesAttempted" => $faker->numberBetween($min=40, $max=60),
        "tacklesWon" => $faker->numberBetween($min=0, $max=39),
        "dribblesAttempted" => $faker->numberBetween($min=25, $max=35),
        "successfullDribbles" => $faker->numberBetween($min=1, $max=24),
        "chancesCreated" => $faker->numberBetween($min=0, $max=35),
        "shots" => $faker->numberBetween($min=30, $max=40),
        "shotsOnTarget" => $faker->numberBetween($min=0, $max=29),
        "goalContributionScore" => 0,
        "tacklesScore" => 0,
        "dribblesScore" => 0,
        "chancesCreatedScore" => 0,
        "shotTargetScore" => 0,
        "passesScore" => 0,
        "foulsScore" => 0,
        "cardsScore" => 0,
        "totalScore" => 0,
        "defScore" => 0,
        "attScore" => 0,
    ];
});
