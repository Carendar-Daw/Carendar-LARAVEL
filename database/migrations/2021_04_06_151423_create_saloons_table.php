<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaloonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saloons', function (Blueprint $table) {
            $table->bigIncrements('sal_id');
            $table->string('sal_name', 25);
            $table->string('sal_location', 50);
            $table->string('sal_email', 30);
            $table->integer('sal_phone');
            $table->integer('sal_appointment_delay');
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
        Schema::dropIfExists('saloons');
    }
}
