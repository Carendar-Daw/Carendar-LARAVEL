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
            $table->string('sal_location', 150)->nullable();
            $table->string('sal_email', 128)->unique();
            $table->integer('sal_phone')->nullable();
            $table->string('auth0_id',50)->unique();
            $table->string('sal_brand', 255)->nullable();
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
