<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {

        $data['companies'] = Company::latest()->get();
        return view('frontend.oldhome', $data);
        return view('frontend.home', $data);
        return view('website.index');

    }

    public function joinCont($id){
        $lastDashPos = strrpos($id, '-');
        $lastPart = substr($id, $lastDashPos + 1);
        $group = Group::where('uuid', $lastPart)->first();
        $numAlreadyJoined = $group->members->count();
        dd($numAlreadyJoined);
        dd($lastPart);
        dd($id);
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
