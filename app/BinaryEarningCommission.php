<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;

class BinaryEarningCommission extends Model
{
    protected $table = 'binary_earning_commissions';

    protected $fillable = [
    	'cust_id', 'left_child_id', 'right_child_id', 'amount',
    ];

    public function sponsor()
    {
    	return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }

    public function left_child()
    {
    	return $this->belongsTo(Customer::class, 'left_child_id', 'id');
    }

    public function right_child()
    {
    	return $this->belongsTo(Customer::class, 'right_child_id', 'id');
    }
}
