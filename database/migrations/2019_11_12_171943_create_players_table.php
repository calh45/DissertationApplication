<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("userId")->unsigned();
            $table->bigInteger("clubId")->unsigned();
            $table->bigInteger("teamId")->unsigned();
            $table->string("position");
            $table->integer("age");
            $table->float("balance");
            $table->integer("appearances");
            $table->integer("yellowCards");
            $table->integer("redCards");
            $table->integer("goals");
            $table->integer("assists");
            $table->integer("passesAttempted");
            $table->integer("passesCompleted");
            $table->integer("fouls");
            $table->double("totalScore");
            $table->string("technical");
            $table->string("psychological");
            $table->string("physical");
            $table->string("social");
            $table->timestamps();

            $table->foreign("userId")->references("id")->on("users")->onDelete("cascade")->
                onUpdate("cascade");
            $table->foreign("clubId")->references("id")->on("clubs")->onDelete("cascade")->
            onUpdate("cascade");
            $table->foreign("teamId")->references("teamId")->on("teams")->onDelete("cascade")->
            onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
