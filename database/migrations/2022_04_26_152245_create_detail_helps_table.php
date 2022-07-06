<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailHelpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_helps', function (Blueprint $table) {
            $table->id();
            $table->integer('help_id');
            $table->foreign('help_id')->references('id')->on('helps');
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('admin_users');
            $table->integer('state_id');
            $table->foreign('state_id')->references('id')->on('states');
            $table->string('solution');
            $table->date('date');
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
        Schema::dropIfExists('detail_helps');
    }
}
