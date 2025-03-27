<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifikasiTable extends Migration
{
    public function up()
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->text('pesan');
            $table->enum('tipe', ['info', 'warning', 'success', 'danger'])->default('info');
            $table->boolean('telah_dibaca')->default(false);
            $table->enum('tipe_peneliti', ['mahasiswa', 'non_mahasiswa'])->nullable();
            $table->foreignId('user_id')->nullable()->constrained('user')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->nullable()->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('non_mahasiswa_id')->nullable()->constrained('non_mahasiswa')->onDelete('cascade');
            $table->text('alasan_penolakan')->nullable();
            $table->foreignId('penerbitan_surat_id')->nullable()->constrained('penerbitan_surat')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifikasi');
    }
}