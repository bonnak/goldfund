<?php

namespace App\Http\Controllers\Auth;

use App\Country;
use App\Customer;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;
use App\Acme\Binary;
use App\Notifications\VerifyCustomerRegister;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $ref = request()->query('ref');        
        $sponsor = Customer::find(($ref === null || $ref < 1) ? 1 : $ref);
        $countries = Country::all();


        return view('auth.register', compact('sponsor', 'countries'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255|unique:customers',
            'email' => 'required|email|max:255|unique:customers',
            'password' => 'required|min:6|confirmed',
            'first_name' => 'required',
            'last_name' => 'required',
            'country_id' => 'required',
            'gender' => 'required',
            'bitcoin_account' => 'required',
            'date_of_birth' => 'required',
            'direction' => 'required',
            'agree_term_condition' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $customer = Customer::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'first_name' => $data['first_name'],
            'country_id' => $data['country_id'],
            'is_active' => false,
            'last_name' => $data['last_name'],
            'gender' => $data['gender'],
            'date_of_birth' => Carbon::createFromFormat('Y-m-d', $data['date_of_birth'])->toDateTimeString(),
            'sponsor_id' => $data['sponsor_id'],
            'placement_id' => Binary::lastPlacement($data['direction'], $data['sponsor_id'])->id,
            'bitcoin_account' => $data['bitcoin_account'],
            'direction' => $data['direction'],
            'agree_term_condition' => $data['agree_term_condition'] == 'on' ? true : false,
            'verified_token' => hash_hmac('sha256', str_random(40), $data['username'] . $data['password']),
        ]);


        // Broadcast a new memerber just register.
        event(new \App\Events\NewMemberRegistered($customer));

        // Notify user must activate their account.
        //$customer->notify(new VerifyCustomerRegister());

        return $customer;
    }


    public function confirm($token)
    {        
        $user = Customer::whereVerifiedToken($token)->first();

        if (!$user)
        {
            throw new InvalidConfirmationCodeException;
        }
        
        $user->is_active = true;
        $user->verified_date = Carbon::now();
        $user->save();

        session()->flash('message', 'You have successfully verified your account.');

        return redirect('login');        
    }
}
