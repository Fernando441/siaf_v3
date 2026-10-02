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
        Schema::table('seminuevos_apartado', function (Blueprint $table) {
            $table->unsignedBigInteger('vendedor_user_id')->nullable()->after('iduserCreated');
            $table->foreign('vendedor_user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->dropColumn('vendedor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seminuevos_apartado', function (Blueprint $table) {
            $table->dropForeign(['vendedor_user_id']);
            $table->dropColumn('vendedor_user_id');
            $table->string('vendedor', 200)->nullable()->after('iduserCreated');
        });
    }
};
