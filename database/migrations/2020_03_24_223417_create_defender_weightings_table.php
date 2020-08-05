<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefenderWeightingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defender_weightings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double("csScore");
            $table->double("aerialDuelScore");
            $table->double("tackleScore");
            $table->double("shotBlockedScore");
            $table->double("pensGivenScore");
            $table->double("foulsScore");
            $table->double("totalScore");
            $table->double("ballPlayScore");
            $table->double("attackingThreatScore");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('defender_weightings');
    }
}
