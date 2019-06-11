<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternshipProfessorEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_professor_evaluations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('student_id')->unsigend();
            $table->bigInteger('professor_id');
            $table->text('evaluation');
            $table->timestamps();
            $table->foreign('student_id', 'int_prof_eval_stud_id')
                  ->references('id')
                  ->on('students');
            $table->foreign('professor_id', 'int_prof_eval_prof_id')
                  ->references('id')
                  ->on('people');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internship_professor_evaluations', function (Blueprint $table) {
            $table->dropForeign('int_prof_eval_prof_id');
            $table->dropForeign('int_prof_eval_stud_id');
        });
        Schema::dropIfExists('internship_professor_evaluations');
    }
}
