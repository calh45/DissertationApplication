<?php

use App\StrikerWeightings;
use Illuminate\Database\Seeder;

class StrikerWeightingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $toAdd = new StrikerWeightings();
        $toAdd->goalsScore = 20;
        $toAdd->assistsScore = 30;
        $toAdd->shotsOnTargetScore = 30;
        $toAdd->chancesCreatedScore = 10;
        $toAdd->penaltiesScore = 5;
        $toAdd->totalScore = 10;
        $toAdd->save();
    }
}
