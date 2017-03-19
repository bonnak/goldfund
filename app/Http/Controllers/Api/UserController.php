<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use App\Exceptions\InvalidPasswordException;
use App\Http\Requests\ChangePasswordRequest;

class UserController extends Controller
{

    public function getProfile(){
        $user_id = auth()->user()->id;
        $user = Customer::with('country')->where('customers.id', $user_id)->first();
        if($user->image) {
            $user->image = 'data:image/jpeg;base64,' . base64_encode(\Storage::get($user->image));
        }
        return $user->toArray();
    }

    public function updateProfile(Request $request)
    {
        $user = Customer::find($request->id);

        $user->email = $request->email;
        $user->password = $request->password;
  		$user->first_name = $request->first_name; 
  		$user->last_name = $request->last_name; 
  		$user->gender = $request->gender; 
  		$user->country_id = $request->country_id;
  		$user->date_of_birth = $request->date_of_birth; 
  		$user->bitcoin_account = $request->bitcoin_account;
        $user->image = $request->image;
        $user->save();

        return response()->json(['msg' => 'Update successfully']);
    }

    public function changePassword(Request $request)
    {      
      $user = Customer::find(auth()->user()->id);

      if(! \Hash::check($request->current_password, $user->password))
      {
        throw new InvalidPasswordException('Current password is incorrect');
      }

      $user->password = $request->new_password;

      if($request->has('second_password') && trim($request->second_password) !== ''){
        $user->trans_password = $request->second_password;
      }      

      return (int) $user->save() === 1 ? 
                  response(['msg' => 'Password change successfully'], 200) :
                  response(['msg' => 'Failed to change password'], 422);
    }

    public function upload(Request $request)
    {
        $photo = $request->file('file');
        if( is_null($photo) || !$photo->isValid())
        {
            throw new HttpException(403, 'uploaded file is corrupted.');
        }
        return $photo->store('images/users');
    }

}
