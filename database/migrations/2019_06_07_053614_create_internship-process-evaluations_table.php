<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternshipProcessEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_process_evaluations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('student_id')->unsigend();
            $table->text('evaluation');
            $table->timestamps();
            $table->foreign('student_id', 'int_proc_eval_stud_id')
                  ->references('id')
                  ->on('students');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internship-process-evaluations', function (Blueprint $table) {
            $table->dropForeign('int-proc-eval_stud-id');
        });
        Schema::dropIfExists('internship-process-evaluations');
    }
}
