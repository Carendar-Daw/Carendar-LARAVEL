<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockByServicesAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_by__services__appointments', function (Blueprint $table) {
            $table->bigIncrements('sbs_id');
            $table->unsignedBigInteger('sto_id');
            $table->foreign('sto_id')->references('sto_id')->on('stocks');
            $table->unsignedBigInteger('sba_id');
            $table->foreign('sba_id')->references('sba_id')->on('services__by__appointments');
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
        Schema::dropIfExists('stock__by__services__appointments');
    }
}
