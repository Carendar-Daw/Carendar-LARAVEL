<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesByAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services__by__appointments', function (Blueprint $table) {
            $table->bigIncrements('sba_id');
            $table->unsignedBigInteger('app_id');
            $table->foreign('app_id')->references('app_id')->on('appointments');
            $table->unsignedBigInteger('ser_id');
            $table->foreign('ser_id')->references('ser_id')->on('services');
            $table->string('sba_state', 20);
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
        Schema::dropIfExists('services__by__appointments');
    }
}
