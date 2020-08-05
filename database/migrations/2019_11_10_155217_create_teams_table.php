<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements("teamId");
            $table->bigInteger("clubId")->unsigned();
            $table->string("teamName");
            $table->bigInteger("managerId")->unsigned()->nullable();
            $table->string("managerEmail");
            $table->double("subscription");
            $table->timestamp("subscriptionDate");
            $table->timestamps();

            $table->foreign("clubId")->references("id")->on("clubs")->onDelete("cascade")->
                onUpdate("cascade");
            $table->foreign("managerId")->references("id")->on("managers")->onDelete("cascade")->
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
        Schema::dropIfExists('teams');
    }
}
