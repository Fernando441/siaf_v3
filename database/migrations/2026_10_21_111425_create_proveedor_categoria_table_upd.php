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
        Schema::create('proveedor_categoria', function (Blueprint $table) {
            $table->id();
            $table->string('categoria', 50)->nullable();
            $table->timestamps();
            $table->bigInteger('iduserCreated')->unsigned()->index();
            $table->bigInteger('iduserUpdated')->unsigned()->index();
            $table->tinyInteger('id_status_delete')->unsigned()->index()->notNull();
            $table->foreign('iduserCreated')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('iduserUpdated')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedor_categoria');
    }
};
