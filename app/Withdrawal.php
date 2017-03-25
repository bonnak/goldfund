<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;

class Withdrawal extends Model
{
    protected $table = 'withdrawals';

    protected $fillable = ['cust_id', 'amount', 'status'];

    public function owner()
    {
    	return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }

    public function allowWithdraw()
    {
    	return false;
    }
}
