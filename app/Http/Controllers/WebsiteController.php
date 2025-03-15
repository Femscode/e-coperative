<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Group;
use App\Models\Company;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WebsiteController extends Controller
{
    public function index()
    {

        return redirect('/login');
        $data['companies'] = Company::latest()->get();
        return view('frontend.home', $data);
        

    }

    public function joinCont($id){
        $lastDashPos = strrpos($id, '-');
        $lastPart = substr($id, $lastDashPos + 1);
        // dd($lastPart);
        $key = 'intended_route';
        if(Auth::user()){
            if (Session::has($key)) {
                Session::forget($key);
            }
        }else{
            if (!Session::has($key)) {
                // Store the current route (or the previous route) in the session
                Session::put($key, request()->url()); // Use url()->previous() to get the previous URL
            }
            return redirect()->route("login");
        }
        $data['group']=  $group = Group::where('uuid', $lastPart)->first();
        $member = GroupMember::where('user_id', auth()->user()->id)->where('group_id', $group->id)->first();
        if($member){
            return redirect()->route('dashboard');
        }
        // dd($group);
        if($group){
            $data['numAlreadyJoined'] = $group->members->count();
            return view('ajo.join', $data);
        }else{
            return redirect()->back();
        }
        // dd($numAlreadyJoined);
        // dd($lastPart);
        // dd($id);
    }
    public function about()
    {
        return view('website.about');
    }
    public function contact()
    {
        return view('website.contact');
    }
    public function plan()
    {
        return view('website.plan');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = User::search($query)->get();
        dd($results);
        return view('search', compact('results'));
    }
    public function checkpayment()
    {
        return view('frontend.checkpayment');
    }

    public function list()
    {
        $data['companies'] = $data['cooperatives'] = $cooperatives = Company::paginate(10);
        return view('frontend.cooperativelist', $data); // Pass to the view
    }

    public function show($id)
    {
        $cooperative = Company::findOrFail($id);
        return view('cooperatives.details', compact('cooperative'));
    }
}
