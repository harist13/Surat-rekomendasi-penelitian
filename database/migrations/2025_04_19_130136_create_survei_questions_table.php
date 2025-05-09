<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveiQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('survei_questions', function (Blueprint $table) {
            $table->id();
            $table->text('pertanyaan');
            $table->string('kepuasan_pelayanan')->default('1 2 3 4 5');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('survei_questions');
    }
}