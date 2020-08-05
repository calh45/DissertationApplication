<?php

use App\DefenderWeightings;
use Illuminate\Database\Seeder;

class DefenderWeightingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $toAdd = new DefenderWeightings();
        $toAdd->csScore = 20;
        $toAdd->aerialDuelScore = 30;
        $toAdd->tackleScore = 30;
        $toAdd->shotBlockedScore = 10;
        $toAdd->pensGivenScore = 5;
        $toAdd->foulsScore = 10;
        $toAdd->totalScore = 100;
        $toAdd->ballPlayScore = 100;
        $toAdd->attackingThreatScore = 100;
        $toAdd->save();
    }
}

