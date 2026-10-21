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
        Schema::create('seminuevos_apartado_facturacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_seminuevos_apartado')->index();
            $table->date('fecha');
            $table->string('nombre_asesor', 200);
            $table->string('nombre_cliente', 200);
            $table->string('rfc', 20);
            $table->string('direccion_completa', 500);
            $table->string('forma_pago', 100);
            $table->string('uso_cfdi', 100);
            $table->string('unidad_medida', 100);
            $table->string('clave_producto', 100);
            $table->decimal('importe_facturar', 12, 2);
            $table->unsignedBigInteger('iduserCreated')->index();
            $table->timestamps();

            $table->foreign('id_seminuevos_apartado')->references('id')->on('seminuevos_apartado')->onDelete('no action')->onUpdate('no action');
            $table->foreign('iduserCreated')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->unique('id_seminuevos_apartado', 'uniq_apartado_facturacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seminuevos_apartado_facturacion');
    }
};


