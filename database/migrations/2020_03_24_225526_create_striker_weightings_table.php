<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrikerWeightingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('striker_weightings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double("goalsScore");
            $table->double("assistsScore");
            $table->double("shotsOnTargetScore");
            $table->double("chancesCreatedScore");
            $table->double("penaltiesScore");
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
        Schema::dropIfExists('striker_weightings');
    }
}
