<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_history', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->text('notes')->nullable();
            $table->enum('tipe_peneliti', ['mahasiswa', 'non_mahasiswa']);
            $table->foreignId('mahasiswa_id')->nullable()->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('non_mahasiswa_id')->nullable()->constrained('non_mahasiswa')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('user')->onDelete('set null');
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
        Schema::dropIfExists('status_history');
    }
}