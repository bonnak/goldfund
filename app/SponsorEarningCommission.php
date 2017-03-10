<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SponsorEarningCommission extends Model
{
    protected $table = 'sponsor_earning_commissions';

    protected $fillable = [ 'sponsor_id', 'deposit_id', 'amount' ];
}
