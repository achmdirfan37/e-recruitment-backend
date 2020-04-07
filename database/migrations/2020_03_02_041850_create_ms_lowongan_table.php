<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsLowonganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_lowongan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('low_judul', 50)->nullable();
            $table->text('low_deskripsi')->nullable();
            $table->integer('low_gaji')->nullable();
            $table->date('low_tanggal_ditutup')->nullable();
            $table->string('low_kualifikasi', 10)->nullable();
            $table->integer('low_jabatan')->nullable();
            $table->integer('low_perusahaan')->nullable();
            $table->integer('low_bidang_kerja')->nullable();
            $table->integer('low_spesialisasi')->nullable();
            $table->string('low_status_aktif', 10)->nullable();
            $table->integer('low_created_by')->nullable();
            $table->integer('low_updated_by')->nullable();
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
        Schema::dropIfExists('ms_lowongan');
    }
}
