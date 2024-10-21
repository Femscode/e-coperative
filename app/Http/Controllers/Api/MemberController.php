<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\MemberLoan;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class MemberController extends Controller
{
    function respond($status, $message, $data, $code)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function transactions(){
        $transactions = Transaction::where('user_id',  auth()->user()->id)->orWhere('email', auth()->user()->email)->where('status', 'Success')->get();
        return $this->respond('success', "Transaction fetched successfully", $transactions, 201);

    }
    public function rangeActivities(Request $request){
        try{
            $yourToken = $request->bearerToken();
            $token = \Laravel\Sanctum\PersonalAccessToken::findToken($yourToken);
            // Get the assigned user
            $user = $token->tokenable;
            $data = $request->all();

            $validator = Validator::make($data, [
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);

            if($validator->fails()) {
               return response()->json(['message' => $validator->errors()], 400);
           }
           $date = date('Y-m-d', strtotime($user->created_at));
           $data['activities'] = Activity::where('is_global', '=', 1)
           ->whereBetween('date', [$request->start_date, $request->end_date])
           ->orwhere(
               function($query) use ($request){
                 return $query
                        ->where('user_id', Auth::user()->id)
                        ->whereBetween('date', [$request->start_date, $request->end_date]);
                })
                ->get();
            return response ([
                "data" => $data,
            ], 201);
        }catch (\Exception $e) {
            return response ([
                "message" =>  $e->getMessage()
            ], 401);
        }
    }

    public function pTransactions(){
        $startDate = Carbon::parse(Auth::user()->created_at);
        $endDate = Carbon::now();
        $currentDate = $startDate->copy()->startOfMonth();
        while ($currentDate->lte($endDate) && $currentDate->month <= $endDate->month) {
            $monthsToView[] = $currentDate->format('F Y');
            $currentDate->addMonth();
        }
        // dd($monthsToView);
        $myMonths = Transaction::where('user_id',  auth()->user()->id)->where([['status', 'Success'],['payment_type','Monthly Dues']])->pluck('month')->toArray();
        // dd($monthsToView, $myMonths);
        $months = [];
        foreach ($monthsToView as $thisMonth) {
            $check =  in_array($thisMonth, $myMonths);
            if ($check == false) {
                $months[] = ['source' => '1', 'month' => $thisMonth];
            }
        }
        // $data['months'] = $months ;
        $data['plan'] = Auth::user()->plan();
        // check if member has ongoing loan application
        $check = MemberLoan::where([['user_id', auth()->user()->id],['status', 'Ongoing']])->first();
        $dateArray = [];
        if($check){
            $payback = $data['plan']->loan_month_repayment - 1;
            $loanDate = Carbon::parse($check->disbursed_date);
            // dd($loanDate);
            $endMonth = Carbon::parse($check->disbursed_date)->addMonths($payback);
            // Loop through the months between start date and current date
            while ($loanDate->lessThanOrEqualTo($endMonth)) {
                $availableNow[] = $loanDate->format('F Y');
                $loanDate->addMonth();
            }
            //check if any payment has been made for this loan
            $checkPayment = Transaction::where('user_id',  auth()->user()->id)->where([['status', 'Success'],['payment_type','Repayment'],['uuid', $check->uuid]])->pluck('month')->toArray();
            // $dateArray = [];
            // dd($availableNow);
            foreach ($availableNow as $pay) {
                $spue =  in_array($pay, $checkPayment);
                $now = now()->format('F Y');
                // dd($now,$pay);
                if ($spue == false && \DateTime::createFromFormat('F Y', $pay) <= \DateTime::createFromFormat('F Y', $now)) {
                    $dateArray[] = ['source' => '2', 'month' => $pay, 'amount' => $check->monthly_return, 'uuid' => $check->uuid] ;
                }
            }
        }
        // dd($dateArray);
        $data['months'] = array_merge($months, $dateArray);
        $transactions = $data['months'] ;
        // dd($transactions);
        foreach($transactions as $key => $transaction){
            $modifiedTransaction = $transaction;
            $modifiedTransaction['id'] = $key + 1;
            if (array_key_exists('amount', $transaction)) {
                // Key 'month' exists in the array
                // Perform actions here
                // ...
                $modifiedTransaction['type'] = "Repayment";
                $modifiedTransaction['original'] = $modifiedTransaction['amount'];
            } else {
                // Key 'month' does not exist in the array
                $modifiedTransaction['amount'] = $data['plan']->getMondays($transaction['month']) * $data['plan']->monthly_dues + $data['plan']->monthly_charge;
                $modifiedTransaction['type'] = "Monthly Dues";
                $modifiedTransaction['uuid'] = "";
                $modifiedTransaction['original'] = $data['plan']->getMondays($data['plan']['month']) * $data['plan']->monthly_dues;
                // Handle this scenario
                // ...
            }
            $newTransactions[] = $modifiedTransaction;
            // dd($transaction);
        }
        return $this->respond('success', "Transaction fetched successfully", $newTransactions, 201);

    }

    public function duesPayment(Request $request){

        $data = $request->all();
        // dd($formattedNumber);
        $input = $request->all();
        // amount to pay

        $fees = $data['checkedTransactionData'];

        $amount = preg_replace('/[^\d.]/', '', $data['totalCheckedAmount'])  ;
        $input['password'] = Hash::make($request->password);
        $input['amount'] = $amount ;
        $input['plan_id'] = Auth::user()->plan_id;
        $input['email'] = Auth::user()->email;
        $input['phone'] = Auth::user()->phone;
        $tag = date("dY");
        $input['transaction_id'] = $transaction_id = intval($tag) + rand(0, 30) * 50;
        foreach($fees as $key => $fee){
            // dd($fee['fee']);
            $input['uuid'] = $fee['uuid'] ;
            $input['month'] = $fee['month'] ;
            $input['balance'] = floatval($fee['amount']) ;
            $input['original'] = floatval($fee['original']) ;
            $input['payment_type'] =$fee['type'];
            $transaction = Transaction::create($input);
        }
        $paystackAPIKey = env("PAYSTACK_SECRET_KEY");
        $paystackEndpoint = 'https://api.paystack.co/transaction/initialize';
        // $transaction->update(["transaction_id" => $transaction_id]);
         // Make a request to Paystack to initialize a transaction and get the payment link
         $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $paystackAPIKey,
            'Content-Type' => 'application/json',
        ])->post($paystackEndpoint, [
            'amount' => $amount * 100, // Replace with your actual amount
            'email' => $input['email'], // Replace with customer email
            'order_id' => $transaction, // Replace with customer email
            'reference' => $transaction_id, // Replace with customer email
            // Other required parameters
        ]);

        $responseData = $response->json();

        if ($response->ok()) {
            $paymentLink = $responseData['data']['authorization_url'];
            return $this->respond('success', "Transaction fetched successfully", $paymentLink, 201);

        } else {
            return response()->json(['error' => 'Failed to generate payment link'], 500);
        }

    }
}
