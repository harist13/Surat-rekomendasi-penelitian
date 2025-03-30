<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerbitansuratTable extends Migration
{
    public function up()
    {
        Schema::create('penerbitan_surat', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_surat', 100);
            $table->string('nomor_surat', 50)->unique();
            $table->string('menimbang', 100);
            $table->enum('status_penelitian', ['baru', 'lanjutan', 'lama']);
            $table->enum('status_surat', ['draft', 'diterbitkan'])->default('draft');
            $table->string('posisi_surat', 100);
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->nullable()->constrained('mahasiswa')->onDelete('set null');
            $table->foreignId('non_mahasiswa_id')->nullable()->constrained('non_mahasiswa')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penerbitan_surat');
    }
}
