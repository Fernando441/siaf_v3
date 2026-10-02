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
        Schema::create('requisicion_conversion', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('requisicion_id')->index()->notNull();
            $table->bigInteger('requisicion_grupo_id')->index()->notNull();
            $table->string('documento', 150)->notNull();
            $table->string('mime_type', 70);
            $table->unsignedDecimal('monto', $precision = 8, $scale = 2);
            $table->date('fecha');
            $table->bigInteger('iduserCreated')->unsigned()->index();
            $table->bigInteger('iduserUpdated')->unsigned()->index();
            $table->foreign('iduserCreated')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('iduserUpdated')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->foreign('requisicion_id')->references('id')->on('requisicion')->onDelete('no action')->onUpdate('no action');
            $table->foreign('requisicion_grupo_id')->references('id')->on('requisicion_grupo')->onDelete('no action')->onUpdate('no action');
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
        Schema::dropIfExists('requisicion_conversion');
    }
};
