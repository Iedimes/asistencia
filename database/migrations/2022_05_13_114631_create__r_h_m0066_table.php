<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRHM0066Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_r_h_m0066', function (Blueprint $table) {
            $table->id();
            $table->integer('FuncNro');
            $table->string('FuncNom');
            $table->string('FUsuCod');
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
        Schema::dropIfExists('_r_h_m0066');
    }
}
