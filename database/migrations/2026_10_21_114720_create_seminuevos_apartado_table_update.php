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
        Schema::create('seminuevos_apartado', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_unidad_venta')->index();
            $table->bigInteger('iduserCreated')->unsigned()->index();
            $table->string('vendedor', 200)->nullable();
            $table->integer('dias_apartado')->unsigned();
            $table->foreign('id_unidad_venta')->references('id')->on('unidad_venta')->onDelete('no action')->onUpdate('no action');
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
        Schema::dropIfExists('seminuevos_apartado');
    }
};

