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
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('trans_password');
            $table->string('first_name');
            $table->string('last_name');
            $table->char('gender', 1);
            $table->date('date_of_birth');    
            $table->integer('country_id')->unsigned();        
            $table->boolean('is_active')->default(0);
            $table->string('bitcoin_account')->unique();
            $table->integer('sponsor_id')->unsigned()->nullable();
            $table->integer('placement_id')->unsigned()->nullable();
            $table->char('direction', 1)->nullable();
            $table->boolean('agree_term_condition');
            $table->string('verified_token');
            $table->string('verified_date')->nullable();
            $table->rememberToken();
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
