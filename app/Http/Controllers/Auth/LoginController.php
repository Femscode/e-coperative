<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo ; //= RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo()
    {
        switch(Auth::user()->user_type){
            case 'Admin':

                    $this->redirectTo = '/admin';
            return $this->redirectTo;
                break;

            case 'Member':

                    $this->redirectTo = '/member';

                return $this->redirectTo;
                break;


            default:
                $this->redirectTo = '/logout';
                return $this->redirectTo;
        }

        // return $next($request);
    }

    public function logout()
    {
        Session::flush();
        if (Auth::check()) {
            $user = auth()->user();
            // Update the name column with the new value
            $user->active = 0; // Replace with your form input field name
            // Save the user model to update the database
            $user->save();
        }
        Auth::logout();

        return redirect('/login');
    }

}
