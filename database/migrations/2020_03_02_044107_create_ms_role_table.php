<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rol_username', 20)->nullable();
            $table->string('rol_password', 20)->nullable();
            $table->string('rol_nama_lengkap', 100)->nullable();
            $table->integer('rol_perusahaan')->nullable();
            $table->string('rol_email', 50)->nullable();
            $table->string('rol_no_telepon', 20)->nullable();
            $table->string('rol_status_aktif', 10)->nullable();
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
        Schema::dropIfExists('ms_role');
    }
}
