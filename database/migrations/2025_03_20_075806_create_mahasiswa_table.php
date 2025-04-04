<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('no_pengajuan')->unique();
            $table->string('nama_lengkap', 255);
            $table->bigInteger('nim')->unique();
            $table->string('email', 100)->unique();
            $table->bigInteger('no_hp')->unique();
            $table->text('alamat_peneliti');
            $table->string('nama_instansi', 255);
            $table->text('alamat_instansi');
            $table->string('jurusan', 255);
            $table->text('judul_penelitian');
            $table->string('lama_penelitian', 100);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('lokasi_penelitian');
            $table->text('tujuan_penelitian');
            $table->text('anggota_peneliti')->nullable();
            $table->enum('status', ['diproses', 'diterima', 'ditolak'])->default('diproses');
            $table->string('surat_pengantar_instansi', 255);
            $table->string('proposal_penelitian', 255);
            $table->string('ktp', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
