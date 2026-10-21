<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidad_tramite_gps_doc', function (Blueprint $table) {
            $table->id();
            $table->integer('unidad_id')->unsigned()->index();
            $table->bigInteger('id_evidencia')->index();
            $table->bigInteger('unidad_tramite_gps_info_id')->index();
            $table->string('documento')->nullable();
            $table->bigInteger('iduserCreated')->unsigned()->index();
            $table->foreign('unidad_id')->references('id')->on('unidad')->onDelete('no action')->onUpdate('no action');
            $table->foreign('id_evidencia')->references('id')->on('unidad_tramite_gps_evidencia')->onDelete('no action')->onUpdate('no action');
            $table->foreign('iduserCreated')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('unidad_tramite_gps_info_id')->references('id')->on('unidad_tramite_gps_info')->onDelete('no action')->onUpdate('no action');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        Schema::dropIfExists('unidad_tramite_gps_doc');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
};

