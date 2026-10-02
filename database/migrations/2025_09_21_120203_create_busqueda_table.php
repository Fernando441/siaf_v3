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
        Schema::create('busqueda', function (Blueprint $table) {
            $table->id();
            $table->uuid('bid')->unique()->notNull(); //id unico de la busqueda
            $table->text('parametros')->notNull(); //termino de busqueda
            $table->bigInteger('iduserCreated')->unsigned()->index();
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
        Schema::dropIfExists('busqueda');
    }
};
