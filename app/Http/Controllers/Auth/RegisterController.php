<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Country;
use App\Customer;
use App\TempPasswordStore;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;
use App\Notifications\VerifyCustomerRegister;
use App\Notifications\SendCustomerRegisterInfo;
use App\Exceptions\InvalidConfirmationCodeException;

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

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return view('auth.register_success', compact('user'));
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
            'sponsor_id' => 'required',
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
            'trans_password' => $trans_password = str_random(8),
            'first_name' => $data['first_name'],
            'country_id' => $data['country_id'],
            'is_active' => false,
            'last_name' => $data['last_name'],
            'gender' => $data['gender'],
            'date_of_birth' => Carbon::createFromFormat('Y-m-d', $data['date_of_birth'])->toDateTimeString(),
            'sponsor_id' => $data['sponsor_id'],
            'placement_id' => Customer::lastPlacement($data['direction'], $data['sponsor_id'])->id,
            'bitcoin_account' => $data['bitcoin_account'],
            'direction' => $data['direction'],
            'agree_term_condition' => $data['agree_term_condition'] == 'on' ? true : false,
            'confirmed' => false,
            'verified_token' => hash_hmac('sha256', str_random(40), $data['username'] . $data['password']),
        ]);    

        // Broadcast a new memerber just register.
        event(new \App\Events\NewMemberRegistered($customer));

        // Notify user must activate their account.
        $customer->with('sponsor')
                ->find($customer->id)
                ->notify(new VerifyCustomerRegister($data['password'], $trans_password));

        return $customer;
    }


    public function confirm($token)
    {       
        $customer = Customer::whereVerifiedToken($token)->first();

        if(!$customer || $customer->confirmed == true)
        {
            return redirect('/');
        }
        
        $customer->is_active = true;
        $customer->confirmed = true;
        $customer->verified_date = Carbon::now();
        $customer->save();

        return view('auth.confirm');        
    }
}
