<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\NumberCount;
use App\Models\User;
use App\Models\WithdrawRequest;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function index(Request $request){
        $user = auth()->user();
        $company = Company::where('uuid',$user->company_id)->first();
        
        $data['users'] = User::where('company_id',$company->uuid)->where('user_type', 'Admin')->get();
        $data['members'] = User::where('company_id',$company->uuid)->where('user_type','!=' ,'Admin')->get();
       
        return view('cooperative.admin.users', $data);
        return view('user_home', $data);
    }

    public function add(Request $request){
        try {
            $input = $request->all();
            $admin = $user = Auth::user();
            $company = $coopD = Company::where('uuid', $user->company_id)->first();
            if (!$company) {
                $company = $coopD =Company::find($user->company_id);
            }
            
            $checkNumber =  NumberCount::where('coop_id', $admin->company_id)->first();
            
            // attempt to give new member coop id
            if ($checkNumber) {
                $code = $checkNumber->count + 1;
                $checkNumber->update([
                    "count" => $checkNumber->count + 1,
                ]);
            } else {
                $code = 1;
                NumberCount::create([
                    "count" => 1,
                    'coop_id' => $admin->company_id
                ]);
            }
            
           
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'user_type' => 'member',
                'company_id' => $admin->company_id,
                'coop_id' => convertToUppercase($coopD->name) . '' . $code,
                'password' => Hash::make($input['password']),
            ]);
            

            return redirect()->back()->with('message', 'User created successfully');

        } catch (\Exception $exception) {
           
            return redirect()->back()->with('error',$exception->getMessage());
            return redirect()->back()->withErrors(['exception' => $exception->getMessage()]);
        }
    }
    public function make_admin(Request $request){
        try {
            $input = $request->all();
            $user = User::find($request->user_id);
            $user->user_type = "Admin";
            $user->save();
           

            return redirect()->back()->with('message', 'User made admin successfully');

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
    public function remove_user(Request $request)
    {
       
        $user = User::find($request->id);
        $user->user_type = 'Member';
        $user->save();

        return redirect()->back()->with('message', 'User removed successfully');
    }
    public function download_member_template() {
        // dd('here');
        $path = public_path("member_import.xlsx");
    
    if (File::exists($path)) {
        return Response::download($path, 'member_import.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    } else {
        return redirect()->back()->with('error', 'File not found.');
    }
    }

    public function fetchProfile() {
        $user = auth()->user();

        return response()->json($user);
    }

    public function withdrawRequest() {
        try {
            $user = auth()->user();
            $input = request()->all();
            
            // Validate required fields
            if (!isset($input['transaction_id']) || !isset($input['pin'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Transaction ID and PIN are required'
                ], 400);
            }

            // Verify user's PIN (assuming PIN is stored as a hashed value in the user's record)
            // if (!Hash::check($input['pin'], $user->pin)) {
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => 'Invalid PIN'
            //     ], 400);
            // }

            // Create withdrawal request
            $group = Group::where('uuid', $input['transaction_id'])->first();
            $group_members = GroupMember::where('group_id', $group->id)->count();
            $amount = $group_members * $group->amount;
            
           
            $withdrawRequest = WithdrawRequest::create([
                'user_id' => $user->uuid,
                'group_id' => $input['transaction_id'],
                'amount' => $amount,
                'status' => 2, // Default status as per migration
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Withdrawal request submitted successfully',
                'data' => $withdrawRequest
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
