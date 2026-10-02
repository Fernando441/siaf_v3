<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestor_documentos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_gestor')->index();
            $table->string('documento')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('descripcion', 150)->nullable();
            $table->bigInteger('iduserCreated')->unsigned()->index();
            $table->foreign('id_gestor')->references('id')->on('unidad_tramite_gestor')->onDelete('no action')->onUpdate('no action');
            $table->foreign('iduserCreated')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
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
        Schema::dropIfExists('gestor_documentos');
    }
};
