<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRhm006AndUsuarioTablesForTesting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('RHM006')) {
            Schema::create('RHM006', function (Blueprint $table) {
                $table->string('FuncNro')->primary();
                $table->string('FuncNom')->nullable();
                $table->string('FUsuCod')->nullable();
                $table->string('FuncEst')->default('A');
                $table->string('DepenCod')->nullable();
                $table->string('FuncADpto')->nullable();
            });
        }

        if (!Schema::hasTable('USUARIO')) {
            Schema::create('USUARIO', function (Blueprint $table) {
                $table->string('UsuCed')->primary();
                $table->string('UsuNombre')->nullable();
                $table->string('UsuCod')->nullable();
                $table->string('Usuest')->default('A');
                $table->string('DepenCod')->nullable();
            });
        }

        if (!Schema::hasTable('SIG008')) {
            Schema::create('SIG008', function (Blueprint $table) {
                $table->string('DepenCod')->primary();
                $table->string('DepenDes')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('RHM006');
        Schema::dropIfExists('USUARIO');
        Schema::dropIfExists('SIG008');
    }
}
