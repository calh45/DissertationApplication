<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalkeepersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goalkeepers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("playerId")->unsigned();
            $table->integer("cleanSheets");
            $table->integer("shotsFaced");
            $table->integer("shotsSaved");
            $table->integer("pensFaced");
            $table->integer("pensSaved");
            $table->integer("pensGivenAway");
            $table->integer("crossesClaimed");
            $table->double("csScore");
            $table->double("saveScore");
            $table->double("penSaveScore");
            $table->double("crossScore");
            $table->double("totalScore");
            $table->double("ballPlayScore");
            $table->double("commandBoxScore");
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
        Schema::dropIfExists('goalkeepers');
    }
}
