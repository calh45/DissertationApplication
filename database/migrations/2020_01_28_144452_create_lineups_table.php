<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("match_id");
            $table->string("formation");
            $table->unsignedBigInteger("one");
            $table->unsignedBigInteger("two");
            $table->unsignedBigInteger("three");
            $table->unsignedBigInteger("four");
            $table->unsignedBigInteger("five");
            $table->unsignedBigInteger("six");
            $table->unsignedBigInteger("seven");
            $table->unsignedBigInteger("eight");
            $table->unsignedBigInteger("nine");
            $table->unsignedBigInteger("ten");
            $table->unsignedBigInteger("eleven");
            $table->unsignedBigInteger("twelve")->nullable();
            $table->unsignedBigInteger("thirteen")->nullable();
            $table->unsignedBigInteger("fourteen")->nullable();
            $table->unsignedBigInteger("fifteen")->nullable();
            $table->unsignedBigInteger("sixteen")->nullable();
            $table->unsignedBigInteger("seventeen")->nullable();
            $table->unsignedBigInteger("eighteen")->nullable();
            $table->timestamps();

            $table->foreign("match_id")->references("id")->on("calendar_events")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lineups');
    }
}
