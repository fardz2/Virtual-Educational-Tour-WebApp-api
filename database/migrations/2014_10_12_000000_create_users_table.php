<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->unsignedBigInteger('role_id');
            $table->string('nama_lengkap')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempat_kelahiran')->nullable();
            $table->date("tanggal_lahir")->nullable();
            $table->string("agama")->nullable();
            $table->string("alamat_tempat_tinggal_sekarang")->nullable();
            $table->string("pendidikan")->nullable();
            $table->bigInteger("nomor_ponsel")->nullable();
            $table->string("orang_terpercaya")->nullable();
            $table->string("status_orang_tersebut")->nullable();
            $table->bigInteger("yang_dapat_dihubungi")->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
