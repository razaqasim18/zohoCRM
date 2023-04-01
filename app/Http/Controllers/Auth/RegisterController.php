<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use DB;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function showRegistrationForm()
    {
        $country = Country::all();
        return view('auth.register', [
            'country' => $country,
        ]);
    }

    protected function showRegistrationSecondForm(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'companyname' => ['required', 'string', 'max:255'],
            'country' => ['required'],
            // 'mobile' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $country = Country::all();
        $state = State::where('country_id', $request->country)->get();
        $name = $request->name;
        $companyname = $request->companyname;
        $select_country = $request->country;
        $mobile = $request->mobile;
        $email = $request->email;
        $password = $request->password;

        return view('auth.register_second', [
            'country' => $country,
            'state' => $state,
            'name' => $name,
            'companyname' => $companyname,
            'select_country' => $select_country,
            'mobile' => $mobile,
            'email' => $email,
            'password' => $password,
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'companyname' => ['required', 'string', 'max:255'],
            'country' => ['required'],
            'state' => ['required'],
            // 'tax_registration_number_trn' => ['required'],
            // 'tax_registration_number_date' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    protected function create(array $data)
    {
        DB::beginTransaction();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
            'is_business_admin' => '1',
            'is_blocked' => '0',
        ]);
        $business = Business::insert([
            'user_id' => $user->id,
            'business' => $data['companyname'],
            'country_id' => $data['country'],
            'state_id' => $data['state'],
            'city' => $data['city'],
            'street1' => $data['street1'],
            'street2' => $data['street2'],
            'zipcode' => $data['zipcode'],
            'is_vat' => (!empty($data['is_vat'])) ? $data['is_vat'] : 0,
            'tax_registration_number_label' => $data['tax_registration_number_label'],
            'tax_registration_number_trn' => $data['tax_registration_number_trn'],
            'tax_registration_number_date' => $data['tax_registration_number_date'],
        ]);
        if ($business && $user) {
            DB::commit();
            return $user;
        } else {
            DB::rollback();
            return false;
        }
    }
}
