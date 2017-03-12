<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BinaryEarningCommission extends Model
{
    protected $table = 'binary_earning_commissions';

    protected $fillable = [
    	'cust_id', 'left_child_id', 'right_child_id', 'amount',
    ];
}
