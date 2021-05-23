<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash__registers', function (Blueprint $table) {
             $table->bigIncrements('cas_id');
            $table->unsignedBigInteger('sal_id');
            $table->foreign('sal_id')->references('sal_id')->on('saloons');
            $table->integer('cas_open');
            $table->integer('cas_current');
            $table->string('cas_state', 20);
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
        Schema::dropIfExists('cash__registers');
    }
}
