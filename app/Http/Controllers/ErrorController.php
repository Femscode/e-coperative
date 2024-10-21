<?php

namespace App\Http\Controllers;
use App\Models\ErrorLog;
use Illuminate\Http\Request;
use DB;
class ErrorController extends Controller
{
    public function index(){
        // $data['errors'] = DB::table('error_logs')->select('url','email','created_at')->take(5);
        // dd($data);
        return view('admin.error.index');
    }
}
