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
        Schema::table('unidad_venta', function (Blueprint $table) {
            $table->smallInteger('cedula_fiscal')->unsigned()->nullable()->after('apartado_politicas');
            $table->smallInteger('ine_vigente')->unsigned()->nullable()->after('cedula_fiscal');
            $table->smallInteger('comprobante_pago')->unsigned()->nullable()->after('ine_vigente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unidad_venta', function (Blueprint $table) {
            $table->dropColumn('cedula_fiscal');
            $table->dropColumn('ine_vigente');
            $table->dropColumn('comprobante_pago');
        });
    }
};
