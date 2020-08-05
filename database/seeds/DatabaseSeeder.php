<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ClubsSeeder::class);
        $this->call(PlayersTableSeeder::class);
        $this->call(GoalkeeperTablerSeeder::class);
        $this->call(DefenderTableSeeder::class);
        $this->call(MidfielderTableSeeder::class);
        $this->call(StrikerTableSeeder::class);
        $this->call(GoalkeeperWeightingsSeeder::class);
        $this->call(DefenderWeightingsSeeder::class);
        $this->call(MidfielderWeightingsSeeder::class);
        $this->call(StrikerWeightingsSeeder::class);
    }
}
