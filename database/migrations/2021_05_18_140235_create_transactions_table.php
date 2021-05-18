<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('tra_id');
            $table->unsignedBigInteger('cus_id');
            $table->foreign('cus_id')->references('cus_id')->on('customers');
            $table->unsignedBigInteger('app_id');
            $table->foreign('app_id')->references('app_id')->on('appointments');
            $table->unsignedBigInteger('sal_id');
            $table->foreign('sal_id')->references('sal_id')->on('saloons');
            $table->integer('tra_total');
            $table->integer('tra_received');
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
        Schema::dropIfExists('transactions');
    }
}
