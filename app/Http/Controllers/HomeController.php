<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['now'] = Carbon::now();
        $data['users'] = User::all();
        $transacts = Transaction::where('status','Success');
        $data['transactions'] = $transacts->get();
        $data['monthly'] = $transacts->whereMonth('created_at', '=', now()->format('m'))->paginate(20);
        return view('admin.home', $data);
    }
}
