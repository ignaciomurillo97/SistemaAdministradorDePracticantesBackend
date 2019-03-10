<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PeoplePerEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peoplePerEvent', function (Blueprint $table) {
            $table->unsignedInteger('event_id');
            //$table->foreign('event_id')->references('id')->on('events');
            $table->unsignedInteger('person_id');
            //$table->foreign('person_id')->references('id')->on('people');
            $table->boolean('confirmed');
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
        Schema::dropIfExists('peoplePerEvent');
    }
}
