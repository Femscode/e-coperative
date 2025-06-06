<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PendingRegistration;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // dd($request->all());
        
        $this->validate($request, [
            'name' => ['required', 'unique:companies'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required',  'max:13', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'pin' => ['required']
        ]);
        $data = $request->all();
        $randomNumber = rand(1, 1000);
        $prefix = strtoupper(substr($request->name, 0, 3));
        $uuid = $prefix . str_pad($randomNumber, 4, '0', STR_PAD_LEFT);
      
        $company = Company::create([
            'name' => $request->name,
            'slug' => str_replace(' ', '', $request->name),
            'description' => $request->description,
            'address' => $request->address,
            'uuid' => $uuid,
            'type' => $request->type,
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_type' => 'Admin',
            'password' => Hash::make($data['password']),
            'company_id' => $company->uuid,
            'pin' => Hash::make($request->pin)
        ]);
        Auth::login($user);
        return redirect('/dashboard ')->with('message', 'Registration Successful! Proceed to login');
        // return redirect(RouteServiceProvider::HOME);
    }

    public function signup($slug = null)
    {
        // return redirect()->route('register');
      
        $data['coperative'] = Company::where('visibility', 'public')->get();
        if ($slug !== null) {
            $data['company'] = $company = Company::where('slug', $slug)->first();
        }
        $data['slug'] = $slug;
        return view('auth.register', $data);
    }

    public function register_user(Request $request)
    {
        $data = $request->all();
      
        // return Validator::make($data, [
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ]);
        // dd('here');


        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_type' => 'Member',
            'password' => Hash::make($data['password']),
            'company_id' => $data['company'],
            'address' => $data['address'],
            'referred_by' => $data['referred_by']
        ]);
        Auth::login($user);
        // return redirect(RouteServiceProvider::HOME);
        return redirect('/dashboard')->with('message', 'Registration Successful! Proceed to login');
    }
    public function signup_user(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'address' => ['required'],
            'company' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // dd($request->company);
        try {
            $company = Company::find($request->company);

            if (!$company) {
                return response()->json([
                    'status' => false,
                    'message' => 'Selected cooperative not found'
                ], 404);
            }
            //check if company will have to approve members before joining
            // if($company->visibility == "private"){
            //     // insert to pending reg 
            //     $user = PendingRegistration::create([
            //         'name' => $data['name'],
            //         'email' => $data['email'],
            //         'user_type' => 'Member',
            //         'password' => Hash::make($data['password']),
            //         'company_id' => $company->uuid,
            //         'address' => $data['address'],
            //         'referred_by' => $data['referred_by'] ?? null
            //     ]);
            // }
            //$status 
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'user_type' => 'Member',
                'password' => Hash::make($data['password']),
                'company_id' => $company->uuid,
                // 'address' => $data['address'],
                'referred_by' => $data['referred_by'] ?? null,
                'status' => $company->visibility == "private" ? NULL : 1,
                'pin' => Hash::make($request->pin),
            ]);

            Auth::login($user);

            return response()->json([
                'status' => true,
                'message' => 'Registration Successful!',
                'redirect' => '/welcome'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Registration failed. Please try again.'
            ], 500);
        }
    }

    public function demoLogin() {
        return view('auth.demo-login');
    }
}
