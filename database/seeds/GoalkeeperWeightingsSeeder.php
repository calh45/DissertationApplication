<?php

use App\GoalkeeperWeightings;
use Illuminate\Database\Seeder;

class GoalkeeperWeightingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $toAdd = new GoalkeeperWeightings();
        $toAdd->csScore = 35;
        $toAdd->saveScore = 35;
        $toAdd->penSaveScore = 10;
        $toAdd->crossScore = 10;
        $toAdd->totalScore = 100;
        $toAdd->ballPlayScore = 100;
        $toAdd->commandBoxScore = 0;
        $toAdd->save();
    }
}
