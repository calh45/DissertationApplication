<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMidfieldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('midfielders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("playerId")->unsigned();
            $table->integer("tacklesAttempted");
            $table->integer("tacklesWon");
            $table->integer("dribblesAttempted");
            $table->integer("successfullDribbles");
            $table->integer("chancesCreated");
            $table->integer("shots");
            $table->integer("shotsOnTarget");
            $table->double("goalContributionScore");
            $table->double("tacklesScore");
            $table->double("dribblesScore");
            $table->double("chancesCreatedScore");
            $table->double("shotTargetScore");
            $table->double("passesScore");
            $table->double("foulsScore");
            $table->double("cardsScore");
            $table->double("totalScore");
            $table->double("defScore");
            $table->double("attScore");
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
        Schema::dropIfExists('midfielders');
    }
}
