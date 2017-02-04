<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->unique();
            $table->string('surname');
            $table->string('given_name');
            $table->char('gender', 1);
            $table->date('date_of_birth');
            $table->string('ssid')->nullable();
            $table->string('block_chain_code')->nullable();
            $table->integer('sponsor_id')->unsigned()->nullable();
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
