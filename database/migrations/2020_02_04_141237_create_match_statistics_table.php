<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("event_id");
            $table->string("home");
            $table->string("away");
            $table->string("score");
            $table->string("goals");
            $table->timestamps();

            $table->foreign("event_id")->references("id")->on("calendar_events")->
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
        Schema::dropIfExists('match_statistics');
    }
}
