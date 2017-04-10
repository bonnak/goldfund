<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_payments', function (Blueprint $table) {
            $table->increments('paymentID');
            $table->integer('boxID')->unsigned()->default(0)->index();
            $table->enum('boxType', ['paymentbox','captchabox'])->index();
            $table->string('orderID', 50)->default('')->index();
            $table->string('userID', 50)->default('')->index();
            $table->string('countryID', 3)->default('')->index();
            $table->string('coinLabel', 6)->default('')->index();
            $table->double('amount', 20, 8)->default(0.00000000)->index();
            $table->double('amountUSD', 20, 8)->default(0.00000000)->index();
            $table->tinyInteger('unrecognised')->unsigned()->default(0)->index();
            $table->string('addr', 34)->default('')->index();
            $table->char('txID', 64)->default('')->index();
            $table->dateTime('txDate')->nullable()->index();
            $table->tinyInteger('txConfirmed')->unsigned()->default(0)->index();
            $table->dateTime('txCheckDate')->nullable()->index();
            $table->tinyInteger('processed')->unsigned()->default(0)->index();
            $table->dateTime('processedDate')->nullable()->index();
            $table->dateTime('recordCreated')->nullable()->index();

            $table->index(['boxID','orderID']);
            $table->index(['boxID','orderID','userID']);
            $table->unique(['boxID', 'orderID', 'userID', 'txID', 'amount', 'addr']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crypto_payments');
    }
}
