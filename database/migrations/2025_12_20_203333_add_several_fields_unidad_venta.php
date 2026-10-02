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
            $table->decimal('compra', 8, 2)->nullable();
            $table->decimal('media', 8, 2)->nullable();
            $table->decimal('ajustes_sobre_valor', 8, 2)->nullable();
            $table->decimal('autometrica', 8, 2)->nullable();
            $table->decimal('ajustes_conversion', 8, 2)->nullable();
            $table->decimal('conversion', 8, 2)->nullable();
            $table->decimal('conversion_ajuste', 8, 2)->nullable();
            $table->decimal('venta_final', 8, 2)->nullable();
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
            $table->dropColumn('compra');
            $table->dropColumn('media');
            $table->dropColumn('ajustes_sobre_valor');
            $table->dropColumn('autometrica');
            $table->dropColumn('ajustes_conversion');
            $table->dropColumn('conversion');
            $table->dropColumn('conversion_ajuste');
            $table->dropColumn('venta_final');
        });
    }
};
