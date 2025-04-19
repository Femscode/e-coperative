<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\MemberLoan;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application cooperative.admin.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['user'] = $user = Auth::user();
       
        $data['now'] = Carbon::now();
        $company = Company::where('uuid',$user->company_id)->first();
        
        $data['users'] = User::where('company_id',$company->uuid)->get();
        $transacts = Transaction::where('company_id',$company->uuid)->where('status','Success');
        $data['transactions'] = $transacts->get();
        $data['monthly'] = $transacts->whereMonth('created_at', '=', now()->format('m'))->where('original','!=',0)->paginate(10);
        $data['plan'] = $company;//Company::find(auth()->user()->company_id);
        $data['loans'] = MemberLoan::where('company_id', $company->id)->get();
       
        if($company->type == 1) {

            return view('cooperative.admin.index', $data);
        } else {
            return view('cooperative.admin.ajo-index', $data);

        }
    }
}
