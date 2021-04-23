<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('sto_id');
            $table->string('sto_barcode',80)->unique();
            $table->unsignedBigInteger('sal_id');
            $table->foreign('sal_id')->references('sal_id')->on('saloons');
            $table->string('sto_name',50);
            $table->integer('sto_pvp');
            $table->integer('sto_amount');
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
        Schema::dropIfExists('stocks');
    }
}
