<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalkeeperWeightingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goalkeeper_weightings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double("csScore");
            $table->double("saveScore");
            $table->double("penSaveScore");
            $table->double("crossScore");
            $table->double("totalScore");
            $table->double("ballPlayScore");
            $table->double("commandBoxScore");
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
        Schema::dropIfExists('goalkeeper_weightings');
    }
}
