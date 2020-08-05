<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defenders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("playerId")->unsigned();
            $table->integer("cleanSheets");
            $table->integer("aerialDuelsWon");
            $table->integer("aerialDuelsLost");
            $table->integer("tacklesAttempted");
            $table->integer("tacklesWon");
            $table->integer("shotsBlocked");
            $table->integer("pensGivenAway");
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

            $table->foreign("playerId")->references("id")->on("players")->
            onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('defenders');
    }
}
