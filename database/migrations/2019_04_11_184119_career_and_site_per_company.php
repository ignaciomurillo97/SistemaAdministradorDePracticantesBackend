<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CareerAndSitePerCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('career_and_site_per_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('career_id');
            $table->bigInteger('site_id');
            $table->integer('company_id');
            $table->enum('status', ['pending', 'aproved', 'denied']);
            $table->timestamps();
            $table->unique(['career_id', 'site_id', 'company_id'], 'unique_relation_CnSperComp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
