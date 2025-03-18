<?php

namespace App\Http\Controllers;

use Paystack;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\GiveawaySchedule;
use App\Traits\TransactionTrait;
use Illuminate\Support\Facades\DB;
use App\Models\DuplicateTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class FundingController extends Controller
{
    //
    use TransactionTrait;
    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {

        try {
            return Paystack::getAuthorizationUrl()->redirectNow();
        } catch (\Exception $e) {

            return Redirect::back()->withMessage(['msg' => 'The paystack token has expired. Please refresh the page and try again.', 'type' => 'error']);
        }
    }

    public function generatePermanentAccount(Request $request)
    {
        // dd($request->all(),env('FLW_SECRET_KEY'));
        $user = Auth::user();
        $str_name = explode(" ", $user->name);
        $first_name = $str_name[0];
        $last_name = end($str_name);
        // return view('dashboard.direct_transfer',$data);  
        // $env = User::where('email', 'fasanyafemi@gmail.com')->first()->remember_token;
        $trx_ref = Str::random(7);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            // 'Authorization' => 'Bearer ' . $env, // Replace with your actual secret key
            'Authorization' => 'Bearer ' . env('FLW_SECRET_KEY'), // Replace with your actual secret key
        ])
            ->post('https://api.flutterwave.com/v3/virtual-account-numbers/', [
                'email' => $user->email,
                'is_permanent' => true,
                'bvn' => $request->bvn,
                'tx_ref' => $trx_ref,
                'phonenumber' => $user->phone,
                'firstname' => $first_name,
                'lastname' => $last_name,
                'narration' => 'VTUBIZ/' . $first_name . '-' . $last_name,
            ]);

        // You can then access the response body and status code like this:
        $responseBody = $response->body(); // Get the response body as a string
        $responseStatusCode = $response->status(); // Get the HTTP status code

        // You can also convert the JSON response to an array or object if needed:
        $responseData = $response->json(); // Converts JSON response to an array


        $user->bank_name = $responseData['data']['bank_name'];
        $user->account_no = $responseData['data']['account_number'];
        $user->account_name = 'VTUBIZ/' . $first_name . '-' . $last_name;
        $user->save();
        return redirect('/fundwallet')->with('message', 'Permanent Account Created Successfully!');
    }

    public function manualpayment(Request $request, $subdomain = null)
    {
        $this->validate($request, [
            'amount' => 'required',
        ]);
        $amount = $request->amount;
        return redirect("https://wa.me/2349058744473?text=Hi+Admin,+I+just+funded+a+total+of+NGN{$amount}.+Kindly+check+and+approve+my+payment.");
    }

    public function generateBankDetails(Request $request)
    {
        $user = Auth::user();
        $str_name = explode(" ", $user->name);
        $first_name = $str_name[0];
        $last_name = end($str_name);
        $trx_ref = Str::random(7);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('FLW_SECRET_KEY'),
        ])
            ->post('https://api.flutterwave.com/v3/virtual-account-numbers/', [
                'email' => $user->email,
                'is_permanent' => false,
                'tx_ref' => $trx_ref,
                'phonenumber' => $user->phone,
                'amount' => $request->amount,
                'firstname' => $first_name,
                'lastname' => $last_name,
                'narration' => 'VTUBIZ/' . $first_name . '-' . $last_name,
            ]);

        $responseData = $response->json();
        
        return response()->json([
            'bank_name' => $responseData['data']['bank_name'],
            'account_no' => $responseData['data']['account_number'],
            'amount' => $responseData['data']['amount'],
            'expiry_date' => $responseData['data']['expiry_date']
        ]);
    }
    public function checkout(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'amount' => 'required',
        ]);
        $data['user'] = $user = Auth::user();
        $data['amount'] = $amount = floatval(str_replace(',', '', $request->amount));

        $data['active'] = 'fundwallet';
        if ($request->type == 'card') {
            $env = env('FLW_PUBLIC_KEY');


            $data['public_key'] = $env;
            // $data['public_key'] = env('FLW_PUBLIC_KEY');
            $data['callback_url'] = 'https://vtubiz.com/payment/callback';
            return view('business_backend.pay_with_card', $data);
        } else {
            $str_name = explode(" ", $user->name);
            $first_name = $str_name[0];
            $last_name = end($str_name);
            // return view('dashboard.direct_transfer',$data);
            // $env = User::where('email', 'fasanyafemi@gmail.com')->first()->remember_token;


            $trx_ref = Str::random(7);
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                // 'Authorization' => 'Bearer ' . $env, // Replace with your actual secret key
                'Authorization' => 'Bearer ' . env('FLW_SECRET_KEY'), // Replace with your actual secret key
            ])
                ->post('https://api.flutterwave.com/v3/virtual-account-numbers/', [
                    'email' => $user->email,
                    'is_permanent' => false,
                    // 'bvn' => 12345678901,
                    'tx_ref' => $trx_ref,
                    'phonenumber' => $user->phone,
                    'amount' => $amount,
                    'firstname' => $first_name,
                    'lastname' => $last_name,
                    'narration' => 'VTUBIZ/' . $first_name . '-' . $last_name,
                ]);

            // You can then access the response body and status code like this:
            $responseBody = $response->body(); // Get the response body as a string
            $responseStatusCode = $response->status(); // Get the HTTP status code

            // You can also convert the JSON response to an array or object if needed:
            $responseData = $response->json(); // Converts JSON response to an array
            // dd($responseData, 'here');
            $data['bank_name'] = $responseData['data']['bank_name'];
            $data['account_no'] = $responseData['data']['account_number'];
            $data['amount'] = $responseData['data']['amount'];
            $data['expiry_date'] = $responseData['data']['expiry_date'];
            return view('business_backend.direct_transfer', $data);
        }
        // dd($request->all(), $request->amount/100);

    }
    public function handleFLWCallback()
    {
        return redirect('/dashboard');
    }

    public function handleGatewayCallback()
    {
        // $paymentDetails = Paystack::getPaymentData();

        // dd($paymentDetails);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
        return redirect('/dashboard');
    }
    public function webhook_payment_for_paystack(Request $request)
    {
        file_put_contents(__DIR__ . '/paystacklog.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);
        $email = $request->input('data.customer.email');
        $r_amountpaid = intval(($request->input('data.amount')) / 100);
        if ($request->input('data.channel') == 'dedicated_nuban') {
            // $amountpaid = $r_amountpaid - 50;
            $amountpaid = $r_amountpaid;
        } elseif ($r_amountpaid < 2500) {
            // $amountpaid = $r_amountpaid - intval((0.02 * $r_amountpaid));
            $amountpaid = $r_amountpaid;
        } else {
            // $amountpaid = $r_amountpaid - intval((0.02 * $r_amountpaid + 100));
            $amountpaid = $r_amountpaid;
        }
        $user = User::where('email', $email)->firstOrFail();
        $details = "Account credited with NGN" . $amountpaid;
        $this->create_transaction('Account Funding', $request->input('data.reference'), $details, 'credit', $amountpaid, $user->id, 1);
        if ($user->first_time == 0) {
            $bonus = intval(0.02 * $amountpaid);
            $details = "You've received a welcome bonus of NGN" . $bonus;
            $this->create_transaction('Bonus Credited', $request->input('data.reference'), $details, 'credit',  $bonus, $user->id, 1);
            $user->first_time = 1;
            $user->save();
        }
        return response()->json("OK", 200);
    }
    public function easywebhook(Request $request)
    {
        file_put_contents(__DIR__ . '/easyaccesswebhook.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);

        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $client_reference = $data['client_reference'];
        $reference = $data['reference'];
        $status =  $data['status'];
        $message = $data['message'];
        $message = preg_replace('/[\/\\\\]/', '-', $message);

        if ($status == 'success' || $status == 'successful') {
            if (substr($client_reference, 0, 3) == 'sgw') {
                $tranx = Transaction::where('reference', $client_reference)
                    ->orderByDesc('created_at')
                    ->first();
                $tranx->reference = $reference;
                $tranx->status = 1;
                $tranx->save();

                $giveaway = GiveawaySchedule::where('reference', $client_reference)->orderByDesc('created_at')
                    ->first();
                $giveaway->reference = $reference;
                $giveaway->status = 1;
                $giveaway->save();
            }

            $url = 'https://vtubiz.com/run_debit/' . $client_reference . '/' . $reference . '/' . $message;
            // file_put_contents(__DIR__ . '/easy_success.json', $url);
            $response = Http::get($url);
        } elseif ($status == 'pending') {
            if (substr($client_reference, 0, 3) == 'sgw') {
                $tranx = Transaction::where('reference', $client_reference)
                    ->orderByDesc('created_at')
                    ->first();
                $tranx->reference = $reference;
                $tranx->status = 2;
                $tranx->save();

                $giveaway = GiveawaySchedule::where('reference', $client_reference)->orderByDesc('created_at')
                    ->first();
                $giveaway->reference = $reference;
                $giveaway->status = 1;
                $giveaway->save();
            }

            $url = 'https://vtubiz.com/run_debit/' . $client_reference . '/' . $reference . '/' . $message;
            // file_put_contents(__DIR__ . '/easy_success.json', $url);
            $response = Http::get($url);
        } elseif ($status == 'failed') {
            if (substr($client_reference, 0, 3) == 'sgw') {
                $tranx = Transaction::where('reference', $client_reference)
                    ->orderByDesc('created_at')
                    ->first();
                $tranx->reference = $reference;
                $tranx->status = 0;
                $tranx->save();

                $giveaway = GiveawaySchedule::where('reference', $client_reference)->orderByDesc('created_at')
                    ->first();
                if ($giveaway) {

                    $giveaway->reference = $reference;
                    $giveaway->status = 0;
                    $giveaway->save();
                }
            }

            $url = 'https://vtubiz.com/run_failed/' . $client_reference . '/' . $reference . '/' . $message;
            $response = Http::get($url);
        } else {
            if (substr($client_reference, 0, 3) == 'sgw') {
                $tranx = Transaction::where('reference', $client_reference)
                    ->orderByDesc('created_at')
                    ->first();
                $tranx->reference = $reference;
                $tranx->status = 0;
                $tranx->save();

                $giveaway = GiveawaySchedule::where('reference', $client_reference)->orderByDesc('created_at')
                    ->first();
                $giveaway->reference = $reference;
                $giveaway->status = 0;
                $giveaway->save();
            }
            $url = 'https://vtubiz.com/run_failed/' . $client_reference . '/' . $reference . '/' . $message;
            $response = Http::get($url);
        }

        return response()->json("OK", 200);
    }
    public function smartwebhook(Request $request)
    {
        file_put_contents(__DIR__ . '/smartwebhook.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);

        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $client_reference = $data['client_reference'];
        $reference = $data['reference'];
        $status =  $data['status'];
        $message = $data['message'];
        $message = preg_replace('/[\/\\\\]/', '-', $message);

        if ($status == 'success' || $status == 'successful') {
            if (substr($client_reference, 0, 3) == 'sgw') {
                $tranx = Transaction::where('reference', $client_reference)
                    ->orderByDesc('created_at')
                    ->first();
                $tranx->reference = $reference;
                $tranx->status = 1;
                $tranx->save();

                $giveaway = GiveawaySchedule::where('reference', $client_reference)->orderByDesc('created_at')
                    ->first();
                $giveaway->reference = $reference;
                $giveaway->status = 1;
                $giveaway->save();
            }

            $url = 'https://vtubiz.com/run_debit/' . $client_reference . '/' . $reference . '/' . $message;
            // file_put_contents(__DIR__ . '/easy_success.json', $url);
            $response = Http::get($url);
        } elseif ($status == 'pending') {
            if (substr($client_reference, 0, 3) == 'sgw') {
                $tranx = Transaction::where('reference', $client_reference)
                    ->orderByDesc('created_at')
                    ->first();
                $tranx->reference = $reference;
                $tranx->status = 2;
                $tranx->save();

                $giveaway = GiveawaySchedule::where('reference', $client_reference)->orderByDesc('created_at')
                    ->first();
                $giveaway->reference = $reference;
                $giveaway->status = 1;
                $giveaway->save();
            }

            $url = 'https://vtubiz.com/run_debit/' . $client_reference . '/' . $reference . '/' . $message;
            // file_put_contents(__DIR__ . '/easy_success.json', $url);
            $response = Http::get($url);
        } elseif ($status == 'failed') {
            if (substr($client_reference, 0, 3) == 'sgw') {
                $tranx = Transaction::where('reference', $client_reference)
                    ->orderByDesc('created_at')
                    ->first();
                $tranx->reference = $reference;
                $tranx->status = 0;
                $tranx->save();

                $giveaway = GiveawaySchedule::where('reference', $client_reference)->orderByDesc('created_at')
                    ->first();
                if ($giveaway) {

                    $giveaway->reference = $reference;
                    $giveaway->status = 0;
                    $giveaway->save();
                }
            }

            $url = 'https://vtubiz.com/run_failed/' . $client_reference . '/' . $reference . '/' . $message;
            $response = Http::get($url);
        } else {
            if (substr($client_reference, 0, 3) == 'sgw') {
                $tranx = Transaction::where('reference', $client_reference)
                    ->orderByDesc('created_at')
                    ->first();
                $tranx->reference = $reference;
                $tranx->status = 0;
                $tranx->save();

                $giveaway = GiveawaySchedule::where('reference', $client_reference)->orderByDesc('created_at')
                    ->first();
                $giveaway->reference = $reference;
                $giveaway->status = 0;
                $giveaway->save();
            }
            $url = 'https://vtubiz.com/run_failed/' . $client_reference . '/' . $reference . '/' . $message;
            $response = Http::get($url);
        }

        return response()->json("OK", 200);
    }

    public function run_debit($client_reference, $reference, $message)
    {
        $tranx = Transaction::where('reference', $client_reference)
            ->orderByDesc('created_at')
            ->first();
        $tranx->reference = $reference;
        // $tranx->description = $message;
        $user = User::find($tranx->user_id);
        $user->balance -= $tranx->amount;
        $user->total_spent += $tranx->amount;

        $earning_amount = 0.05 * $tranx->amount;
        $user->earnings += $earning_amount;
        $user->save();
        $company = User::where('id', $user->company_id)->first();
        $profit = $tranx->amount - floatval($tranx->real_amount);
        $company->balance += $profit;
        $company->save();
        $tranx->after = $user->balance;
        $tranx->status = 1;
        $tranx->admin_after = $company->balance;
        $tranx->redo = 1;
        $tranx->save();
        $duplicate = DuplicateTransaction::where('reference', $client_reference)->latest()->first();
        $duplicate->delete();
    }
    public function run_failed($client_reference, $reference, $message)
    {

        $tranx = Transaction::where('reference', $client_reference)
            ->orderByDesc('created_at')
            ->first();
        $tranx->reference = $reference;
        $tranx->description = $message;
        $tranx->status = 0;
        $tranx->save();
        $duplicate = DuplicateTransaction::where('reference', $client_reference)->latest()->first();
        $duplicate->delete();
    }
    public function webhook_payment(Request $request)
    {
        file_put_contents(__DIR__ . '/flwlog.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);

        $email = $request->input('data.customer.email');
        $r_amountpaid = intval($request->input('data.amount'));

        $amountpaid = $r_amountpaid;
        if ($amountpaid <= 1000) {
            $charges = 25;
            $amountpaid -= $charges;
        } elseif ($amountpaid < 5000) {
            $charges = 50;
            $amountpaid -= $charges;
            // } elseif ($amountpaid < 5000) {
            //     $charges = 50;
            //     $amountpaid -= $charges;
        } else {
            $charges = 100;
            $amountpaid -= $charges;
        }
        $details_paid = $amountpaid + $charges;

        $user = User::where('email', $email)->firstOrFail();
        $details = "Account credited with NGN" . $details_paid . " | Charges (NGN" . $charges . ")";
        // file_put_contents(__DIR__ . '/gethere.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);
        $this->create_transaction('Account Funding', $request->input('data.id'), $details, 'credit', $amountpaid, $user->id, 1);
        if ($user->first_time == 0) {
            $bonus = intval(0.02 * $amountpaid);
            $details = "You've received a welcome bonus of NGN" . $bonus;
            $this->create_transaction('Bonus Credited', $request->input('data.id'), $details, 'credit',  $bonus, $user->id, 1);
            $user->first_time = 1;
            $user->save();
        }
        return response()->json("OK", 200);
    }
    public static function computeSHA512TransactionHash($stringifiedData, $clientSecret)
    {
        $computedHash = hash_hmac('sha512', $stringifiedData, $clientSecret);
        return $computedHash;
    }

    public function transfer()
    {
        $data['user'] =  $user = Auth::user();
        $data['active'] = 'transfer';
        $data['company'] = User::where('id', $user->company_id)->first();
        return view('dashboard.transfer', $data);
    }



    public function verify_id(Request $request)
    {

        $user = User::where('phone', $request->account_id)->first();

        if ($user == null) {
            return false;
        }
        return $user->name;
    }
    public function verify_order(Request $request)
    {
        //CTS-MXPH09riG6 the order id
        $order = DB::connection('mysql2')->table('orders')->where('order_id', $request->order_id)->first();
        if ($order == null) {
            return false;
        }
        $rest = DB::connection('mysql2')->table('users')->where('id', $order->user_id)->first();
        if ($rest == null) {
            return false;
        }
        $order->restaurant_name = $rest->name;

        if ($order == null) {
            return false;
        }
        return $order;
    }
    public function make_transfer(Request $request)
    {
        $user = Auth::user();
        $hashed_pin = hash('sha256', $request->pin);
        if ($user->pin !== $hashed_pin) {
            return "Incorrect Pin";
        }


        if ($user == null) {
            return "Unauthenticated";
        }
        $amount = $request->amount;
        $account_id = $request->account_id;

        $beneficiary = User::where('phone', $account_id)->first();
        //check if beneficiary exists
        if ($beneficiary == null) {
            return "Invalid account";
        }
        //check for the user balance, then fire the transaction
        if ($user->balance >= $amount) {
            $reference = 'fund_transfer_' . Str::random(7);
            $details = "Transfer of NGN" . $amount . ' to ' . $beneficiary->name;
            $check = $this->check_duplicate('check', $user->id);
            if ($check == true) {
                return "Duplicate Transaction";
            }
            $this->create_transaction('Fund Transfer', $reference, $details, 'debit', $amount, $user->id, 1);
            $this->check_duplicate("Delete", $user->id);
            $reference = 'payment_received_' . Str::random(7);
            $details = "Payment of NGN" . $amount . ' from ' . $user->name . ' received successfully!';
            $this->create_transaction('Payment Received', $reference, $details, 'credit', $amount, $beneficiary->id, 1);
            return true;
        }
    }
    public function pay_for_order(Request $request)
    {
        $user = Auth::user();
        $hashed_pin = hash('sha256', $request->pin);
        if ($user->pin !== $hashed_pin) {
            return "Incorrect Pin";
        }
        if ($user == null) {
            return "Unauthenticated";
        }
        $amount = $request->amount;
        $order_id = $request->account_id;
        $order = DB::connection('mysql2')->table('orders')->where('order_id', $request->order_id)->first();
        if ($order == null) {
            return "Invalid Order";
        }
        if ($order->user_id == 53 || $order->user_id == 38) {
            // $amount = $order->total_price + $order->delivery_amount + 50;
            $amount = $order->total_price + 50;
        } else {
            $amount = $order->total_price;
        }

        $rest = DB::connection('mysql2')->table('users')->where('id', $order->user_id)->first();
        if ($rest == null) {
            return "Beneficiary not found";
        }
        $restaurant_phone = $rest->phone;
        if (strlen($restaurant_phone) == 11) {
            $restaurant_phone = substr($restaurant_phone, 1);
        }
        // dd($restaurant_phone);

        //check for the user balance, then fire the transaction
        if ($user->balance >= $amount) {
            $reference = 'fund_transfer_' . Str::random(7);
            $details = "Transfer of NGN" . $amount . ' to ' . $rest->name;
            $check = $this->check_duplicate('check', $user->id);
            if ($check == true) {
                return "Duplicate Transaction";
            }
            $this->create_transaction('Fund Transfer', $reference, $details, 'debit', $amount, $user->id, 1);
            $this->check_duplicate("Delete", $user->id);
            $reference = 'payment_received_' . Str::random(7);
            $data = [
                'order_id' => $order->id,
                'rest_id' => $rest->id,
                'amount' => $amount,
                'before_balance' => $rest->balance,
                'after_balance' => $rest->balance + $amount,
                'reference' => $reference,
                'type' => 'credit',
                'title' => 'Payment of order via VTUBIZ',
                'details' => 'Payment of NGN' . $amount . ' from ' . $user->name,
                'customer_name' => $user->name,
                'customer_phone' => $user->phone,
                'status' => 1
            ];
            DB::connection('mysql2')->table('transactions')->insert($data);
            DB::connection('mysql2')->table('orders')->where('order_id', $request->order_id)->update(['status' => 1, 'payment_time' => Carbon::now()]);
            DB::connection('mysql2')->table('users')->where('id', $rest->id)->update(['balance' => $rest->balance + $amount]);
            return true;
        }
    }
}
