<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsLevelNumberToTblLevelEarningCommission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('level_earning_commissions', function (Blueprint $table) {
            $table->integer('level_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('level_earning_commissions', function (Blueprint $table) {
            $table->dropColumn('level_number');
        });
    }
}
