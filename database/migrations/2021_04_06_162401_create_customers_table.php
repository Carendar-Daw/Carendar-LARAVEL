<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('cus_id');
            $table->string('cus_email', 30)->unique();
            $table->string('cus_color_preference', 25)->default('#8265a7');
            $table->string('cus_name', 20);
            $table->string('cus_photo')->default('defaultAvatar.jpg');
            $table->unsignedBigInteger('sal_id');
            $table->foreign('sal_id')->references('sal_id')->on('saloons');
            $table->date('cus_born_date');
            $table->integer('cus_phone');
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
        Schema::dropIfExists('customers');
    }
}
