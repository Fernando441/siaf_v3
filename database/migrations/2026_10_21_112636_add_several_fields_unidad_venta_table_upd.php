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
            $table->unsignedDecimal('precio_mercado', 8, 2)->nullable();
            $table->unsignedDecimal('precio_venta', 8, 2)->nullable();
            $table->date("fecha_entrega")->nullable();
            $table->date("fecha_pago")->nullable();
            $table->date("fecha_registro_venta")->nullable();
            $table->date("fecha_venta")->nullable();
            $table->string('numero_factura')->nullable();
            $table->string('vendedor_unidad')->nullable();
            $table->string('nombre_cliente')->nullable();
            $table->string('direccion_cliente')->nullable();
            $table->string('identificacion_cliente')->nullable();
            $table->string('rfc')->nullable();
            $table->unsignedBigInteger('id_tipo_persona')->nullable()->unsigned();
            $table->foreign('id_tipo_persona')->references('id')->on('tipo_persona')->onDelete('no action')->onUpdate('no action');
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
            $table->dropColumn('precio_mercado');
            $table->dropColumn('precio_venta');
            $table->dropColumn('fecha_entrega');
            $table->dropColumn('fecha_pago');
            $table->dropColumn('fecha_registro_venta');
            $table->dropColumn('fecha_venta');
            $table->dropColumn('numero_factura');
            $table->dropColumn('vendedor_unidad');
            $table->dropColumn('nombre_cliente');
            $table->dropColumn('direccion_cliente');
            $table->dropColumn('identificacion_cliente');
            $table->dropColumn('rfc');
            $table->dropForeign(['id_tipo_persona']);
            $table->dropColumn('id_tipo_persona');
        });
    }
};
