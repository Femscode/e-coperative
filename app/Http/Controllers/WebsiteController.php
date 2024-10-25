<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index(){
        
        return view('frontend.home');
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
}
