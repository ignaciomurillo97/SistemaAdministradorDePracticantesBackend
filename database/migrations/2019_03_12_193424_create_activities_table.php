<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("activityName");
            $table->time('duration');
            $table->string("charlista");
            $table->text("remarks");
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('legal_id')->on('companies');
            $table->foreign('event_id')->references('id')->on('events');
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
        Schema::dropIfExists('activity');
        Schema::dropIfExists('activities');
    }
}
