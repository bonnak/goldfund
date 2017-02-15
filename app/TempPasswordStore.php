<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempPasswordStore extends Model
{
  protected $table = 'temp_password_stores';

  protected $fillable = [ 'cust_id', 'password', 'trans_password' ];

  public $timestamps = false;
}
