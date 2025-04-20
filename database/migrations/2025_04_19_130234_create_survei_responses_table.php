<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveiResponsesTable extends Migration
{
    public function up()
    {
        Schema::create('survei_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('usia')->nullable();
            $table->integer('rating');
            $table->text('kritik_saran')->nullable();
            $table->string('jenis_layanan')->nullable();
            $table->timestamps();
            
            $table->foreign('question_id')->references('id')->on('survei_questions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('survei_responses');
    }
}