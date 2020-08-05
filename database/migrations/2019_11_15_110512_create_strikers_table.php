<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrikersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strikers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("playerId")->unsigned();
            $table->integer("chancesCreated");
            $table->integer("shots");
            $table->integer("shotsOnTarget");
            $table->integer("headedGoals");
            $table->integer("penaltiesTaken");
            $table->integer("penaltiesScored");
            $table->double("goalsScore");
            $table->double("assistsScore");
            $table->double("shotsOnTargetScore");
            $table->double("chancesCreatedScore");
            $table->double("penaltiesScore");
            $table->double("totalScore");
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
        Schema::dropIfExists('strikers');
    }
}
