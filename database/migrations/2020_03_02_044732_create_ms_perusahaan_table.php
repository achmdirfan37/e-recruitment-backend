<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsPerusahaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_perusahaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('per_foto')->nullable();
            $table->string('per_nama', 50)->nullable();
            $table->text('per_deskripsi')->nullable();
            $table->string('per_email', 50)->nullable();
            $table->string('per_no_telepon', 20)->nullable();
            $table->string('per_alamat_website', 50)->nullable();
            $table->text('per_alamat')->nullable();
            $table->string('per_status_aktif', 10)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        //
        Schema::dropIfExists('ms_role');
    }
}
