<?php

use App\MidfielderWeightings;
use Illuminate\Database\Seeder;

class MidfielderWeightingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $toAdd = new MidfielderWeightings();
        $toAdd->goalContributionScore = 20;
        $toAdd->tacklesScore = 20;
        $toAdd->dribblesScore = 20;
        $toAdd->chancesCreatedScore = 15;
        $toAdd->shotTargetScore = 10;
        $toAdd->passesScore = 15;
        $toAdd->totalScore = 100;
        $toAdd->save();
    }
}
