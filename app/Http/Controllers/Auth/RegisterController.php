<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_type' => 'Admin',
            'password' => Hash::make($data['password']),
        ]);
    }

    public function coop_reg()
    {
        return view('auth.coop_reg');
    }

    public function save_coop_reg(Request $request)
    {
        $data = $request->all();

        $randomNumber = rand(1, 1000);
        $prefix = strtoupper(substr($request->name, 0, 3));
        $uuid = $prefix . str_pad($randomNumber, 4, '0', STR_PAD_LEFT);
        // dd($data);
        // return Validator::make($data, [
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ]);
        // dd('here');
        $company = Company::create([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'uuid' => $uuid,
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_type' => 'Admin',
            'password' => Hash::make($data['password']),
            'company_id' => $company->uuid,
        ]);
        return redirect('/login')->with('message', 'Registration Successful! Proceed to login');
    }
}
