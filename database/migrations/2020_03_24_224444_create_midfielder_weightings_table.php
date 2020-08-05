<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMidfielderWeightingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('midfielder_weightings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double("goalContributionScore");
            $table->double("tacklesScore");
            $table->double("dribblesScore");
            $table->double("chancesCreatedScore");
            $table->double("shotTargetScore");
            $table->double("passesScore");
            $table->double("totalScore");
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
        Schema::dropIfExists('midfielder_weightings');
    }
}
