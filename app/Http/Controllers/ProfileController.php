<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bank;
use Illuminate\Support\Facades\Http;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\OTPMail;
use App\Jobs\OtpNotification;
use Carbon\Carbon;
class ProfileController extends Controller
{
    public function dashboard(){
        if(auth()->check()) {
            if(auth()->user()->user_type == "Admin"){
               
                return redirect()->route('admin-home');
            }else{
                return redirect()->route('member_home');
            }
        }else{
            return redirect()->route('logout');
        }
    }

    public function profile(){
        $data['user'] = $user = Auth::user();
        if(auth()->user()->user_type == "Member"){
            $data['plan'] = $user->plan();
        }
        $data['banks'] = Bank::orderBy('name','asc')->get();
        // dd($plan);
        if($user->user_type == "Admin") {
            return view('cooperative.admin.profile', $data);

        } else {
            return view('cooperative.member.profile', $data);
            return view('member.profile', $data);

        }
    }

    public function otp(){
        // dd("here");
        if (auth()->user()->tfa != 1 && auth()->user()->active != 0 || auth()->user()->tfa == 1 && auth()->user()->active == 1 || auth()->user()->tfa != 1 && auth()->user()->active == 0) {
            if(auth()->user()->user_type == "Admin"){
                return redirect()->route('admin-home');
            }else{
                return redirect()->route('member_home');
            }
        }
        $user = User::find(Auth::user()->id);
        $currentTime = Carbon::now();
        // Calculate the time difference in seconds
        $timeDifference = $currentTime->diffInSeconds($user->updated_at);
        if ($timeDifference > 180) {
            $email =$user->email;
            $otp = rand(1000, 9999);
            $user->update(['tfa_code' =>  Hash::make($otp)]);
            dispatch(new OtpNotification($email,$otp));
        }
        return view('t2fa');
    }

    public function verify(Request $request){
        try{
            $code = $request->a .''. $request->b .''. $request->c .''. $request->d;
            $hashedOTPFromDatabase = auth()->user()->tfa_code;
            $user = User::find(Auth::user()->id);
            // dd($code);
            if (Hash::check($code, $hashedOTPFromDatabase)) {
                $user->update(['active' => 1]);
                return api_request_response(
                    'ok',
                    'OTP validated successfully!',
                    success_status_code(),
                );
            } else {
                // The input OTP does not match the stored hashed OTP
                return api_request_response(
                    'error',
                    "Invalid OTP provided!",
                    bad_response_status_code()
                );
            }

        } catch (\Exception $exception) {
            return api_request_response(
                'error',
                $exception->getMessage(),
                bad_response_status_code()
            );
        }
    }

    public function update(Request $request){
        try {
            $input = $request->except('user_type','password','email','phone','plan_id','coop_id');
           
            $user = Auth::user();
            
            $user->update($input);
                return api_request_response(
                    'ok',
                    'Profile updated successfully!',
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

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => ['required'],
            'new_password' => ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])/','min:6'],
            'confirm_password' => ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])/','min:6'],
        ]);

        $validator->setAttributeNames(['password' => 'Current Password','new_password' => 'New Password','confirm_password' => 'Confirm Password']);

        $validator->setCustomMessages([
            'password.required' => 'The :attribute field is required.',
            'new_password.required' => 'The :attribute field is required.',
            'new_password.regex' => 'The :attribute must contain at least one lowercase letter, one uppercase letter, and one special character.',
            'new_password.min' => 'The :attribute must be at least :min characters.',
            'confirm_password.required' => 'The :attribute field is required.',
            'confirm_password.regex' => 'The :attribute must contain at least one lowercase letter, one uppercase letter, and one special character.',
            'confirm_password.min' => 'The :attribute must be at least :min characters.',
        ]);

        if ($validator->fails()) {
            // dd($validator)
            return api_request_response(
                'error',
                $validator->errors()->first(),
                bad_response_status_code()
            );
        }
        $user =Auth::user();
        $old = $request->password;
        $new = $request->new_password;
        $confirm = $request->confirm_password;
        if (!Hash::check($old, $user->password)) {
            return api_request_response(
                'error',
                "Incorrect old password",
                bad_response_status_code()
            );
        }
        if($new != $confirm){
            return api_request_response(
                'error',
                "Confirm password does not match new password",
                bad_response_status_code()
            );
        }
        if (Hash::check($new, $user->password)) {
            return api_request_response(
                'error',
                "You can't change to current password",
                bad_response_status_code()
            );
        }
        $value = User::where('id', $user->id)->first();
        $password = Hash::make($new);
        $value->password =  $password;
        $value->save();
        return api_request_response(
            'ok',
            'Password changed successfully!',
            success_status_code(),
        );
    }

    public function saveFile(Request $request){
        $user = Auth::user();
        $file = uploadImage($request->file,"file");
        if($request->type == "profile"){
            $user->update(['profile_image'=> $file]);
        }else{
            $user->update(['cover_image'=> $file]);
        }

    }

    public function toggleTwo(Request $request){
        $user = Auth::user();
        $user->update(['tfa' => $request->type, 'active' => 1]);
    }

    public function paystackBanks()
    {
        $key = env("PAYSTACK_SECRET_KEY");
        $url = "https://api.paystack.co/bank";
        $authorization = "Bearer $key";

        $response = Http::withHeaders([
            'Authorization' => $authorization,
        ])->get($url);

        // Check for a successful response and handle it accordingly
        if ($response->successful()) {
            $data = $response->json(); // JSON response data
            foreach($data['data'] as $bank){
                if(!Bank::where('code', $bank['code'])->first()){
                    Bank::create($bank);
                }
            }
            dd("done");
            // Handle the data as needed
        } else {
            // Handle the error response
            $statusCode = $response->status();
            $errorData = $response->json(); // JSON error data
            // Handle the error response accordingly
        }
    }
    public function verifyAccount(Request $request)
    {
        $account_number = $request->account_number;
        $code = $request->code;
        $key = env("PAYSTACK_SECRET_KEY");
        $url = "https://api.paystack.co/bank/resolve?account_number=$account_number&bank_code=$code";
        $authorization = "Bearer $key";

        $response = Http::withHeaders([
            'Authorization' => $authorization,
        ])->get($url);

        // Check for a successful response and handle it accordingly
        if ($response->successful()) {
            $user = Auth::user();
            $data = $response->json(); // JSON response data
            // dd($data)
            $user->update(['bank_code' => $code,'account_name' => $data['data']['account_name'],'account_number' => $data['data']['account_number']]);
            return api_request_response(
                'ok',
                'Bank Details Verified Successfully!',
                success_status_code(),
                $data['data']['account_name']
            );
            // dd($data);
            // Handle the data as needed
        } else {
            // Handle the error response
            $statusCode = $response->status();
            $errorData = $response->json(); // JSON error data
            return api_request_response(
                'error',
                $errorData['message'],
                bad_response_status_code()
            );
            dd($errorData);
            // Handle the error response accordingly
        }
    }

}
