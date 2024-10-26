<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index(){
        
        $data['companies'] = Company::latest()->get();
        return view('frontend.home', $data);
        return view('website.index');

    }
    public function about(){
        return view('website.about');
    }
    public function contact(){
        return view('website.contact');
    }
    public function plan(){
        return view('website.plan');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = User::search($query)->get();
        dd($results);
        return view('search', compact('results'));
    }
    public function checkpayment() {
        return view('frontend.checkpayment');
    }
}
