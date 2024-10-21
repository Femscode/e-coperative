<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if($validator->fails()) {
           return response()->json(['message' => $validator->errors()], 400);
        }

       $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_type' => 'member',
            'password' => Hash::make($data['password']),
        ]);

        $response = [
            'user' => $user,
        ];

        return response(
            [
                "data" => $response,
                "message" => 'Login Successful'
            ],
            201
        );
    }
}
