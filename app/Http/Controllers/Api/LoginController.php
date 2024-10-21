<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // dd($data);
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()) {
           return response()->json(['message' => $validator->errors()], 400);
       }
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response([
                "message" => "Record Not Found"
            ], 401);
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                "message" => "Invalid Credentials"
            ], 401);
        }

        $token = $user->createToken('myAppToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response(
            [
                "data" => $response,
                "message" => 'Login Successful'
            ],
            201
        );
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $data = auth()->user()->tokens()->delete();

        return [
            "message" => "Logged Out"
        ];

        return response(
            [
                "data" => $data,
                "message" => 'Logged Out '
            ],
            201
        );
    }
}
