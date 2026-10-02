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
        Schema::table('seminuevos_apartado_facturacion', function (Blueprint $table) {
            $table->string('correo_electronico', 255)->nullable()->after('rfc');
            $table->string('numero_telefono', 20)->nullable()->after('correo_electronico');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seminuevos_apartado_facturacion', function (Blueprint $table) {
            $table->dropColumn(['correo_electronico', 'numero_telefono']);
        });
    }
};
