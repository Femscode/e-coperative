<?php

namespace App\Http\Controllers;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request){
        $user = auth()->user();
        $data['users'] = User::where('company_id',$user->company_id)->where('user_type', 'Admin')->get();
        return view('dashboard.users', $data);
        return view('user_home', $data);
    }

    public function add(Request $request){
        try {
            $input = $request->all();
            User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'user_type' => 'member',
                'password' => Hash::make($input['password']),
            ]);

            return redirect()->back()->with('message', 'User created successfully');

        } catch (\Exception $exception) {

            return redirect()->back()->withErrors(['exception' => $exception->getMessage()]);
        }
    }

    public function details(Request $request)
    {
        $user = User::where('id', $request->id)->first();

        return response()->json($user);
    }

    public function updateUser(Request $request)
    {
        try {

            $user = User::find($request->id);
           
                $input = $request->all();
                
                $user->update($request->all());
                return api_request_response(
                    'ok',
                    'Record saved successfully!',
                    success_status_code(),
                );

        } catch (\Exception $exception) {
            return api_request_response(
                'error',
                $exception->getMessage(),
                bad_response_status_code()
            );
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $loan = User::find($id);
        // dd($customer);
        $loan->delete();

        return redirect()->back()->with('message', 'User deleted successfully');
    }
    
}
