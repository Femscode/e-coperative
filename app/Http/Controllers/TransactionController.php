<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use function App\Helpers\formatPhoneNumber;
use Illuminate\Support\Facades\Hash;
use App\Models\Transaction;
use App\Models\NumberCount;
use App\Models\MemberLoan;
use Illuminate\Support\Facades\Validator;
use Paystack; // Paystack package
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function planPayment(Request $request)
    {
        ini_set('memory_limit', '256M');
        $data = $request->except('_token');
        // dd($data);
        $validator = Validator::make($data, [
            'referred_by' => ['nullable', 'unique:users'],
            'phone' => 'digits_between:10,11|unique:users,phone',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'referred_by' => 'exists:users,coop_id',
            'company' => 'exists:companies,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        $formattedNumber = formatPhoneNumber($request->phone);
        if ($formattedNumber['status'] == false) {
            return response()->json([
                'status' => 'error',
                'message' => $formattedNumber['message'],
                'data' => $formattedNumber['data'],
            ], 400);
        }
        //check if coop has reg fee
        $coop = Company::where('uuid', $request->company)->first();
        if(!$coop) {
           
            $coop = Company::findOrFail($request->company);
        }
        $fee = $coop->reg_fee;

        // dd($formattedNumber);
        $input = $request->except('_token');
        $input['password'] = Hash::make($request->password);
        $coopD = Company::where('id', $request->company)->first();
        $amount = $coopD->reg_fee;
        // $tag = date("dY");
        $tag = uniqid(). date("dYHis").rand(100, 999);
        $input['transaction_id'] = $transaction_id = intval($tag) + rand(0, 30) * 50 ."". rand();
        if ($fee < 1) {
            $status = 0;
            $checkNumber =  NumberCount::where('coop_id', $coop->id)->first();
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
                    "coop_id" => $coop->id
                ]);
            }
            // $code = mt_rand(100000, 999999);
            $transaction = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $input['password'],
                'user_type' => "Member",
                'coop_id' => convertToUppercase($coopD->name) . '' . $code,
                'company_id' => $coopD->id,
            ]);
            Auth::login($transaction);
        } else {
            // dd("here");
            $status = 1;
            $input['amount'] = $input['balance'] = $amount;
            $input['original'] = $input['balance'] = $amount;
            $input['company_id'] = $coop->id;
            $input['month'] = now()->format('F Y');

            //    dd($input);
            $transaction = Transaction::create($input);
            // $transaction = Transaction::create([
            //     "name" => $input['name'],
            //     "email" => $input['email'],
            //     "phone" => $input['phone'],
            //     "amount" => $input['amount'],
            //     "balance" => $input['amount'],
            //     "referred_by" => $input['referred_by'],
            //     "password" => $input['password'],
            //     "company_id" => $coopD->id,
            // ]);
            // dd("here");
        }


        // $transaction->update(["transaction_id" => $transaction_id]);
        $result = array(
            "transaction_id" => $transaction_id,
            "order_id" => $transaction_id,
            "payment_process" => 1,
            "status" => "success",
            "amount_paid" => $amount,
            "status" => $status,
        );
        echo json_encode($result);
    }
    public function duesPayment(Request $request)
    {

        $data = $request->all();
        // dd($formattedNumber);
        $input = $request->all();
        // amount to pay
        // dd($data['checkedData']);
        $fees = $data['checkedData'];
       
        $amount = preg_replace('/[^\d.]/', '', $data['total_amount']);
        $input['password'] = Hash::make($request->password);
        $input['amount'] = $amount;
        $input['plan_id'] = Auth::user()->plan_id;
        // $tag = date("dY");
        $tag = uniqid(). date("dYHis").rand(100, 999);
        $input['transaction_id'] = $transaction_id = intval($tag) + rand(0, 30) * 50;
        foreach ($fees as $key => $fee) {
            // dd($fee['fee']);
            $input['uuid'] = $fee['uuid'];
            $input['company_id'] = Auth::user()->company_id;
            if (isset($fee['month'])) {
                $input['month'] = $fee['month'];
            } else {
                $input['week'] = $fee['week'];
            }
            $input['month'] = $fee['month'] ?? "";
            $input['balance'] = floatval($fee['fee']);
            $input['original'] = floatval($fee['original'] ?? $fee['fee']);
            $input['payment_type'] = $fee['payment_type'];
            $transaction = Transaction::create($input);
        }

        // $transaction->update(["transaction_id" => $transaction_id]);
        $result = array(
            "transaction_id" => $transaction_id,
            "order_id" => $transaction,
            "payment_process" => 1,
            "status" => "success",
            "amount_paid" => $transaction->amount,
        );
        echo json_encode($result);
    }
    public function anytimePayment(Request $request)
    {

        $data = $request->all();
        // dd($formattedNumber);
        $input = $request->all();
        // amount to pay
        // dd($data['checkedData'][1]['value']);
        $fees = $data['checkedData'];
        $amount = preg_replace('/[^\d.]/', '', $data['checkedData'][1]['value']);
        $input['password'] = Hash::make($request->password);
        $input['amount'] = $amount;
        $input['balance'] = $amount;
        $input['payment_type'] = "Funding";
        $input['user_id'] = Auth::user()->id;
        $input['company_id'] = Auth::user()->company_id;
        // $tag = date("dY");
        $tag = uniqid(). date("dYHis").rand(100, 999);
        $input['month'] = $tag;
        $input['transaction_id'] = $transaction_id = intval($tag) + rand(0, 30) * 50;
        $transaction = Transaction::create($input);

        // $transaction->update(["transaction_id" => $transaction_id]);
        $result = array(
            "transaction_id" => $transaction_id,
            "order_id" => $transaction,
            "payment_process" => 1,
            "status" => "success",
            "amount_paid" => $transaction->amount,
        );
        echo json_encode($result);
    }
    public function formPayment(Request $request)
    {

        $data = $request->all();
        // dd($data);
        // dd($formattedNumber);
        $input = $request->all();
        // amount to pay
        // dd($data['checkedData']);
        $amount = preg_replace('/[^\d.]/', '', $data['total_amount']);
        $input['payment_type'] = "Form";
        $input['password'] = Hash::make($request->password);
        $input['month'] = now()->format('F Y');
        $input['amount'] = $amount;
        $input['plan_id'] = Auth::user()->plan_id;
        $input['user_id'] = Auth::user()->id;
        $input['phone'] = Auth::user()->phone;
        $input['email'] = Auth::user()->email;
        // $tag = date("dY");
        $tag = uniqid(). date("dYHis").rand(100, 999);
        $input['transaction_id'] = $transaction_id = intval($tag) + rand(0, 30) * 50;
        $input['balance'] = $amount;
        $input['original'] = $amount;
        $input['company_id'] = auth()->user()->company_id;
        $transaction = Transaction::create($input);

        // $transaction->update(["transaction_id" => $transaction_id]);
        $result = array(
            "transaction_id" => $transaction_id,
            "order_id" => $transaction,
            "payment_process" => 1,
            "status" => "success",
            "amount_paid" => $transaction->amount,
            "email" => $transaction->email,
            "phone" => $transaction->phone,
        );
        echo json_encode($result);
    }

    public function payazaVerifyPayment(Request $request)
    {
        $this->validate($request, ['order_id' => 'required','reference'=> 'required']);
        // dd($request->all(),$request->reference);
        //process online payment
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://cards-live.78financials.com/card_charge/transaction_status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                    "service_payload": {
                        "transaction_reference": "'.$request->reference.'"
                    }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.env('PAYAZA_API'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $real_response = json_decode($response, true);
        
        // dd($response, $real_response, $real_response['response_code']);
        //dd("here");
        if ($real_response['response_code'] == 200 ) {
            //Required Details
          
                $content = $real_response['response_content'];
               
                $check  = Transaction::where('transaction_id', $request->order_id)->orderBy('created_at', 'desc')->get();
                
                $checks  = Transaction::where('transaction_id', $request->order_id)->update(['status' => "Success"]);
                $checkUser = User::where('email', $check[0]["email"])->first();
                
                foreach ($check as $apply) {
                    $checkForm = MemberLoan::where('uuid', $apply->uuid)->first();
                    if ($checkForm) {
                        if ($checkForm->payment_status == 1) {
                            $balance = $checkForm->total_left;
                            $refund = $checkForm->total_refund;
                            $monthlyRefund = $checkForm->monthly_return;
                            $newRefund =  $refund + $monthlyRefund;
                            $newBalance = $balance - $monthlyRefund;
                            if ($newBalance < 1) {
                                $checkForm->update(['total_left' => $newBalance, 'total_refund' => $newRefund, 'status' => 'Completed']);
                            } else {
                                $checkForm->update(['total_left' => $newBalance, 'total_refund' => $newRefund]);
                            }
                        } else {
                            $checkForm->update(['payment_status' => 1]);
                        }
                    }
                }
                if (!$checkUser) {
                    $coopD = Company::find($check[0]["company_id"]);
                    $checkNumber =  NumberCount::where('coop_id', $check[0]["company_id"])->first();
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
                            'coop_id' => $check[0]["company_id"]
                        ]);
                    }
                    // $code = mt_rand(100000, 999999);
                    $checkUser = User::create([
                        'name' => $check[0]['name'],
                        'email' => $check[0]['email'],
                        'phone' => $check[0]['phone'],
                        'password' => $check[0]['password'],
                        'user_type' => "Member",
                        'coop_id' => convertToUppercase($coopD->name) . '' . $code,
                        'month' => now()->format('F Y'),
                        'referred_by' => $check[0]['referred_by'],
                        'username' => $check[0]['username'],
                        'company_id' => $check[0]["company_id"]
                        // 'plan_id' => $check[0]['plan_id'],
                    ]);
                }
                Transaction::where('transaction_id', $request->order_id)->update(['user_id' => $checkUser->id]);
                Auth::login($checkUser);
            
        }
        return redirect()->route('dashboard')->with('message', 'Payment made successfully');
    }
   

    

    

 
}
