<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempPasswordStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_password_stores', function (Blueprint $table) {
            $table->integer('cust_id')->unsigned();
            $table->string('password')->nullable();
            $table->string('trans_password')->nullable();

            $table->primary('cust_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_password_stores');
    }
}
