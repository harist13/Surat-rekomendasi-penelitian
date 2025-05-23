<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nip')->unique()->nullable();
            $table->string('username', 100)->unique();
            $table->string('password');
            $table->string('no_telp', 20);
            $table->string('email', 100)->unique();
            $table->enum('role', ['admin', 'staff']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user');
    }
}
