<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Earning;
use App\SponsorEarningCommission;
use App\LevelEarningCommission;
use App\BinaryEarningCommission;
use App\Withdrawal;

class CustomerController extends Controller
{
	protected function customerExist($id)
  {
  	$customer = Customer::find($id);

  	if(is_null($customer)) throw new HttpException(422, 'User not found');

  	return $customer;
  }

  protected function emailExist($request)
  {
		if(Customer::where('email', $request->email)
					  					->where('id', '!=',  $request->id)
					  					->exists())
		{
			throw new HttpException(422, 'Email already exist');
		}

		if(!filter_var($request->email, FILTER_VALIDATE_EMAIL))
		{
			throw new HttpException(422, 'Invalid email address.');
		}
  }

  protected function bitcoinExist($request)
  {
		if(Customer::where('bitcoin_account', $request->bitcoin_account)
					  					->where('id', '!=',  $request->id)
					  					->exists())
		{
			throw new HttpException(422, 'Bitcoin account already exist');
		}
  }

  public function getData()
  {       
      extract(request()->all());

      return Customer::with(['sponsor', 'country'])                  
                  ->where(function($inner_query) use ($query){
                      if($query == '') return;

                      $inner_query->where('username', 'like', $query . '%')
                                  ->orWhere('email', 'like', $query . '%')
                                  ->orWhere('bitcoin_account', 'like', $query . '%');                     
                  })
                  ->orderBy('created_at', 'desc')
                  ->paginate($per_page);
  }


  public function editEmail(Request $request)
  {
  	$this->emailExist($request);
  	$customer = $this->customerExist($request->id);

  	$customer->email = $request->email;
  	$customer->save();

  	return  [ 'msg' => 'Email update successfully.'];
  }

  public function editBitcoinAddress(Request $request)
  {
  	$this->bitcoinExist($request);
  	$customer = $this->customerExist($request->id);

  	$customer->bitcoin_account = $request->bitcoin_account;
  	$customer->save();

  	return  [ 'msg' => 'Bitcoin address update successfully.'];
  }

  public function dailyEarning($id)
  {
      return Earning::where('cust_id', $id)->orderBy('created_at', 'desc')->get();
  }

  public function directEarning($id)
  {
      return SponsorEarningCommission::with('deposit.owner')
                                      ->where('sponsor_id', $id)
                                      ->orderBy('created_at', 'desc')
                                      ->get();
  }

  public function levelEarning($id)
  {
      return LevelEarningCommission::with('deposit.owner')
                                    ->where('cust_id', $id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
  }

  public function binaryEarning($id)
  {
      return BinaryEarningCommission::with(['left_child', 'right_child'])
                                    ->where('cust_id', $id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
  }

  public function withdrawal($id)
  {
      return Withdrawal::where('cust_id', $id)->orderBy('created_at', 'desc')->get();
  }
}
