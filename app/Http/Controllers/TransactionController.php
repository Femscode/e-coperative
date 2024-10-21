<?php

namespace App\Http\Controllers;
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
use Paystack;// Paystack package
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function planPayment(Request $request){

        $data = $request->all();
        // dd($data);
        $validator = Validator::make($data, [
            'referred_by' => ['nullable', 'unique:users'],
            'phone' => 'digits_between:10,11|unique:users,phone',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'referred_by' => 'exists:users,coop_id'
        ]);

        if($validator->fails()) {
           return response()->json(['message' => $validator->errors()->first()], 400);
        }

        $formattedNumber = formatPhoneNumber($request->phone);
        if($formattedNumber['status'] == false){
            return response()->json([
                'status' => 'error',
                'message' =>$formattedNumber['message'],
                'data' => $formattedNumber['data'],
            ],400);
        }
        // dd($formattedNumber);
        $input = $request->all();
        // amount to pay
        $fees = $data['fee'];
        $amount = $data['total_amount']  ;
        $input['password'] = Hash::make($request->password);
        $input['amount'] = $amount ;
        $input['month'] = now()->format('F Y');
        $tag = date("dY");
        $input['transaction_id'] = $transaction_id = intval($tag) + rand(0, 30) * 50;
        foreach($fees as $key => $fee){
            // dd($fee);
            $input['balance'] = floatval($fee) ;
            $input['original'] = floatval($request->original[$key]) ;
            $input['payment_type'] =$request->payment_type[$key];
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
    public function duesPayment(Request $request){

        $data = $request->all();
        // dd($formattedNumber);
        $input = $request->all();
        // amount to pay
        // dd($data['checkedData']);
        $fees = $data['checkedData'];
        $amount = preg_replace('/[^\d.]/', '', $data['total_amount'])  ;
        $input['password'] = Hash::make($request->password);
        $input['amount'] = $amount ;
        $input['plan_id'] = Auth::user()->plan_id;
        $tag = date("dY");
        $input['transaction_id'] = $transaction_id = intval($tag) + rand(0, 30) * 50;
        foreach($fees as $key => $fee){
            // dd($fee['fee']);
            $input['uuid'] = $fee['uuid'] ;
            $input['month'] = $fee['month'] ;
            $input['balance'] = floatval($fee['fee']) ;
            $input['original'] = floatval($fee['original']) ;
            $input['payment_type'] =$fee['payment_type'];
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
    public function formPayment(Request $request){

        $data = $request->all();
        // dd($formattedNumber);
        $input = $request->all();
        // amount to pay
        // dd($data['checkedData']);
        $amount = preg_replace('/[^\d.]/', '', $data['total_amount'])  ;
        $input['payment_type'] = "Form";
        $input['password'] = Hash::make($request->password);
        $input['month'] = now()->format('F Y');
        $input['amount'] = $amount ;
        $input['plan_id'] = Auth::user()->plan_id;
        $input['user_id'] = Auth::user()->id;
        $input['phone'] = Auth::user()->phone;
        $input['email'] = Auth::user()->email;
        $tag = date("dY");
        $input['transaction_id'] = $transaction_id = intval($tag) + rand(0, 30) * 50;
        $input['balance'] = $amount ;
        $input['original'] = $amount ;
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

    public function verifyPayment(Request $request){
          //process online payment
          //dd("here");
          if (isset($_GET["reference"]) && !empty($_GET["reference"])) {
            //Required Details
            require("assets/paystack-class-master/Paystack.php");
            $payment_key = env("PAYSTACK_SECRET_KEY");//'sk_test_17ff4ee65864548cbacbe76adc26445b04dd2e05';
            // $payment_key = 'sk_test_91cf1a63ae5745670f6f2daa0871368b0e678934';
            //  $payment_key = 'sk_live_94614973c8c718d21f247f423115780a672b29e0';
            $paystack = new Paystack($payment_key);
            $trx = $paystack->transaction->verify(['reference' => $_GET['reference']]);

            if ('success' == $trx->data->status) {
                // $reference = "172096";
                $reference = $trx->data->reference;
                // $check  = $crud->select("orders_staging", " * ", " transaction_id ='$reference' ");
                $check  = Transaction::where('transaction_id', $reference)->get();
                $checks  = Transaction::where('transaction_id', $reference)->update(['status' => "Success"]);
                $checkUser = User::where('email', $check[0]["email"])->first();
                foreach($check as $apply){
                    $checkForm = MemberLoan::where('uuid', $apply->uuid)->first();
                    if($checkForm){
                        if($checkForm->payment_status == 1){
                            $balance = $checkForm->total_left;
                            $refund = $checkForm->total_refund;
                            $monthlyRefund = $checkForm->monthly_return;
                            $newRefund =  $refund + $monthlyRefund;
                            $newBalance = $balance - $monthlyRefund;
                            if($newBalance < 1){
                                $checkForm->update(['total_left' => $newBalance,'total_refund' => $newRefund,'status' => 'Completed']);
                            }else{
                                $checkForm->update(['total_left' => $newBalance,'total_refund' => $newRefund]);
                            }
                        }else{
                            $checkForm->update(['payment_status' => 1]);
                        }
                    }
                }
                if(!$checkUser){
                    $checkNumber =  NumberCount::first();
                    // attempt to give new member coop id
                    if($checkNumber){
                        $code = $checkNumber->count + 1;
                        $checkNumber->update([
                            "count" => $checkNumber->count + 1,
                        ]);
                    }else{
                        $code = 1;
                        NumberCount::create([
                            "count" => 1,
                        ]);
                    }
                    // $code = mt_rand(100000, 999999);
                    $checkUser = User::create([
                        'name' => $check[0]['name'],
                        'email' => $check[0]['email'],
                        'phone' => $check[0]['phone'],
                        'password' => $check[0]['password'],
                        'user_type' => "Member",
                        'coop_id' => $code,
                        'month' => now()->format('F Y'),
                        'referred_by' => $check[0]['referred_by'],
                        'username' => $check[0]['username'],
                        'plan_id' => $check[0]['plan_id'],
                    ]);
                }
                Transaction::where('transaction_id', $reference)->update(['user_id' => $checkUser->id]);

            }
        }
        return redirect()->back()->with('message', 'Payment made successfully');
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
