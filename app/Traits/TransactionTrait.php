<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Data;
use App\Models\User;
use App\Models\Airtime;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\ScheduleAccount;
use App\Models\GiveawaySchedule;
use App\Models\SchedulePurchase;
use App\Models\DuplicateTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

trait TransactionTrait
{

    public function reserve_account_monnify()
    {
        $user = Auth::user();
        //authentication to monnify
        $api_key = env('MON_API_KEY_TEST');
        $secret_key = env('MON_SECRET_KEY_TEST');

        // Encode API Key and Secret Key
        // $auth_str = base64_encode("$api_key:$secret_key");
        $auth_str = base64_encode("MK_TEST_A8C10B1WC9:FAACQZT5T9UZ1UESMZQ9C0DSYTHB17A1");


        // Set headers for HTTP request
        $headers = [
            'Authorization' => 'Basic ' . $auth_str,
        ];

        // Make HTTP request using Axios
        $response = Http::withHeaders($headers)
            ->post('https://sandbox.monnify.com/api/v1/auth/login', []);
        $response = json_decode($response, true);

        if ($response['requestSuccessful'] == false) {
            return 0;
        }
        // dd($response);
        $access_token = $response['responseBody']['accessToken'];
        // return $access_token;
        $payment_headers = [
            'Authorization' => 'Bearer ' . $access_token,
        ];
        $payment_response = Http::withHeaders($payment_headers)
            ->post('https://sandbox.monnify.com/api/v2/bank-transfer/reserved-accounts', [
                "accountReference" => Str::random(5),
                "accountName" => "Paycirclex " . $user->name,
                "currencyCode" => "NGN",
                "contractCode" => "1699178756",
                "customerEmail" => $user->email,
                // "bvn" => "21212121212",
                "customerName" => $user->name,
                "getAllAvailableBanks" => true
            ]);
        $c_response = json_decode($payment_response, true);
        if ($c_response['requestSuccessful'] == false) {
            return 0;
        }
        $accounts = $c_response['responseBody']['accounts'];
        foreach ($accounts as $account) {
            if ($account['bankCode'] == '035') {
                $user->account_wema = $account['accountNumber'];
            } elseif ($account['bankCode'] == '232') {
                $user->account_sterling = $account['accountNumber'];
            } elseif ($account['bankCode'] == '50515') {
                $user->account_moniepoint = $account['accountNumber'];
            } elseif ($account['bankCode'] == '058') {
                $user->account_gtb = $account['accountNumber'];
            } else {
            }
            $user->save();
        }

        return 1;
    }
    public function reserve_account_paystack()
    {
        $user = Auth::user();
        //generate virtual from paystack
        $full_name = str_word_count($user->name, 1); // Split the full name into an array of words

        $firstName = $full_name[0]; // First name is the first word
        $lastName = end($full_name);

        $url = "https://api.paystack.co/customer";
        $fields = [
            "email" => $user->email,
            "first_name" => $firstName,
            "last_name" => $lastName,
            "phone" => "+234" . $user->phone
        ];
        $fields_string = http_build_query($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer sk_live_dc09eacf4aed817703251640abf8bd4b4f0d007f",
            // "Authorization: Bearer ".env('PAYSTACK_SECRET_KEY'),
            "Cache-Control: no-cache",
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $json_result = json_decode($result, true);
        $customer = $json_result['data']['customer_code'];
        // dd($json_result,$customer,'nic');
        $url = "https://api.paystack.co/dedicated_account";

        $fields = [
            "customer" => $customer,
            "preferred_bank" => "wema-bank",
            "phone" => "234" . $user->phone
        ];

        $fields_string = http_build_query($fields);

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer sk_live_dc09eacf4aed817703251640abf8bd4b4f0d007f",
            // "Authorization: Bearer ".env('PAYSTACK_SECRET_KEY'),
            "Cache-Control: no-cache",
        ));

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute post
        $result = curl_exec($ch);
        $c_response = json_decode($result, true);
        // dd($c_response);

        if ($c_response['status'] == false) {
            return 0;
        }

        $user->bank_name = $c_response['data']['bank']['name'];
        $user->account_name = $c_response['data']['account_name'];
        $user->account_no = $c_response['data']['account_number'];

        $user->save();


        return 1;
    }


    public function create_transaction($title, $reference, $details, $type, $amount, $user, $status, $real_dataprice = null, $phone_number = null, $network = null, $plan_id = null)
    {
        //    dd($title, $details, $type, intval($amount),intval($user),$name);
        $r_user = User::find($user);
        $company = User::where('id', $r_user->company_id)->first();

        $tranx =  Transaction::create([
            'user_id' => $user,
            'company_id' => $company->id,
            'title' => $title,
            'reference' => $reference,
            'description' => $details,
            'before' => $r_user->balance,
            'admin_before' => $company->balance,
            'type' => $type,
            'amount' => $amount,
            'status' => $status
        ]);
        if ($title == 'Fund Transfer') {
            $r_user->balance -= $amount;
            $r_user->save();
            $tranx->after = $r_user->balance;
            $tranx->status = 1;
            $tranx->save();
        } elseif ($title == 'Data Purchase') {
            $tranx->real_amount = $real_dataprice;
            $tranx->phone_number = $phone_number;
            $tranx->network = $network;
            $tranx->plan_id = $plan_id;
            $tranx->save();
            return $tranx->id;
        } elseif ($title == 'Account Funding') {


            $r_user->balance += $amount;
            $r_user->save();
            $tranx->after = $r_user->balance;
            $tranx->status = 1;
            $tranx->save();
            return $tranx->id;
        } elseif ($title == 'Bonus Credited') {


            $r_user->bonus += $amount;

            $r_user->save();
            $tranx->after = $r_user->balance;
            $tranx->status = 1;
            $tranx->save();
            return $tranx->id;
        } elseif ($title == 'Account Funded Through Transfer') {


            $r_user->balance += $amount;

            $r_user->save();
            $tranx->after = $r_user->balance;
            $tranx->status = 1;
            $tranx->save();
            return $tranx->id;
        } elseif ($title == 'Giveaway') {
            $r_user->balance -= $amount;
            $r_user->total_spent += $amount;
            $r_user->save();
            $tranx->after = $r_user->balance;
            $tranx->admin_after = $company->balance;
            $tranx->save();
            return $tranx->id;
        } elseif ($title == 'Airtime Purchase') {
            if ($status == 1) {
                $r_user->balance -= $amount;
                $r_user->total_spent += $amount;
                $r_user->save();
                $profit = $amount - floatval($real_dataprice);
                $company->balance += $profit;
                $company->save();
                $tranx->after = $r_user->balance;
                $tranx->admin_after = $company->balance;
                $tranx->save();
            } else {
                $tranx->description = "Failed Transaction : " . $tranx->description;
                $tranx->after = $r_user->balance;
                $tranx->admin_after = $company->balance;
                $r_user->save();
                $tranx->save();
            }
            //For easy access
            // $company = User::where('id', $r_user->company_id)->first();
            // $tranx->discounted_amount = $real_dataprice;
            // $tranx->phone_number = $phone_number;
            // $tranx->network = $network;
            // $tranx->real_amount = $plan_id;
            // $tranx->save();
            // return $tranx->id;
        } elseif ($title == 'Manual Funding') {

            $r_user->balance += $amount;


            $r_user->save();
            $tranx->after = $r_user->balance;

            $tranx->status = 1;
            $tranx->save();
        } elseif ($title == 'Manual Debit') {

            $r_user->balance += $amount;


            $r_user->save();
            $tranx->after = $r_user->balance;

            $tranx->status = 1;
            $tranx->save();
        } elseif ($title == 'Admin Fund User') {

            $r_user->balance -= $amount;

            $r_user->save();
            $tranx->after = $r_user->balance;

            $tranx->status = 1;
            $tranx->save();
        } elseif ($title == 'Payment Received') {

            $r_user->balance += $amount;

            $r_user->save();
            $tranx->after = $r_user->balance;

            $tranx->status = 1;
            $tranx->save();
        } elseif ($title == 'Remit Earning') {

            $r_user->balance += $amount;

            $r_user->save();
            $tranx->after = $r_user->balance;

            $tranx->status = 1;
            $tranx->save();
        } elseif ($title == 'Account Upgrade') {

            $r_user->balance -= $amount;

            $r_user->save();
            $tranx->after = $r_user->balance;

            $tranx->status = 1;
            $tranx->save();
        } elseif ($title == 'Giveaway Retry') {

            $r_user->balance -= $amount;

            $r_user->save();
            $tranx->after = $r_user->balance;

            $tranx->status = 1;
            $tranx->save();
        } elseif ($title == 'Giveaway Entry Fee') {

            $r_user->balance -= $amount;

            $r_user->save();
            $tranx->after = $r_user->balance;

            $tranx->status = 1;
            $tranx->save();
        } elseif ($title == 'Pending Credit') {


            $r_user->balance += $amount;

            $r_user->save();
            $tranx->after = $r_user->balance;
            $tranx->status = 2;
            $tranx->save();
            return $tranx->id;
        } elseif ($title == 'Funds Withdraw') {


            if ($status == 1) {
                $r_user->balance -= $amount;
                $r_user->save();
                $tranx->after = $r_user->balance;
                $tranx->status = $status;
                $tranx->save();
                return $tranx;
            } else {

                $tranx->after = $r_user->balance;
                $tranx->status = $status;
                $tranx->save();
                return $tranx;
            }

            return $tranx->id;
        } elseif ($title == 'Cable Subscription') {

            $company = User::where('id', $r_user->company_id)->first();
            if ($status == 1) {
                $r_user->balance -= $amount;
                $r_user->total_spent += $amount;
                $r_user->save();
                $profit = $amount - floatval($real_dataprice);
                $company->balance += $profit;
                $company->save();
                $tranx->after = $r_user->balance;
                $tranx->admin_after = $company->balance;
                $tranx->save();
            } else {
                $tranx->description = "Failed Transaction : " . $tranx->description;
                $tranx->after = $r_user->balance;
                $tranx->admin_after = $company->balance;
                $r_user->save();
                $tranx->save();
            }
        } elseif ($title == 'Examination Result Payment') {

            $company = User::where('id', $r_user->company_id)->first();
            if ($status == 1) {
                $r_user->balance -= $amount;
                $r_user->total_spent += $amount;
                $r_user->save();
                $profit = $amount - floatval($real_dataprice);
                $company->balance += $profit;
                $company->save();
                $tranx->after = $r_user->balance;
                $tranx->admin_after = $company->balance;
                $tranx->save();
            } else {
                $tranx->description = "Failed Transaction : " . $tranx->description;
                $tranx->admin_after = $company->balance;
                $tranx->after = $r_user->balance;
                $r_user->save();
                $tranx->save();
            }
        } elseif ($title == 'Electricity Payment') {

            $company = User::where('id', $r_user->company_id)->first();
            if ($status == 1) {
                $r_user->balance -= $amount;
                $r_user->total_spent += $amount;
                $r_user->save();
                $profit = $amount - floatval($real_dataprice);
                $company->balance += $profit;
                $company->save();
                $tranx->after = $r_user->balance;
                $tranx->admin_after = $company->balance;
                $tranx->save();
                return $tranx->id;
            } else {
                $tranx->description = "Failed Transaction : " . $tranx->description;
                $tranx->after = $r_user->balance;
                $tranx->admin_after = $company->balance;
                $r_user->save();
                $tranx->save();
            }
        } elseif ($title == 'Bulk SMS') {

            $company = User::where('id', $r_user->company_id)->first();
            if ($status == 1) {
                $r_user->balance -= $amount;
                $r_user->total_spent += $amount;
                $r_user->save();
                $profit = $amount - floatval($real_dataprice);
                $company->balance += $profit;
                $company->save();
                $tranx->after = $r_user->balance;
                $tranx->admin_after = $company->balance;
                $tranx->save();
                return $tranx->id;
            } else {
                $tranx->description = "Failed Transaction : " . $tranx->description;
                $tranx->after = $r_user->balance;
                $tranx->admin_after = $company->balance;
                $r_user->save();
                $tranx->save();
            }
        } else {
            $tranx->status = 0;

            $tranx->after = $r_user->balance;
            $tranx->save();

            return "not_completed";
        }
    }

    public function create_later_purchase($title, $reference, $details, $user_id, $phone, $network, $discounted_amount, $amount, $date, $time, $transaction_id)
    {
        $user = Auth::user();
        $company_id = User::where('id', $user->company_id)->first()->id;
        if ($title == 'Airtime Purchase') {

            SchedulePurchase::create([
                'title' => $title,
                'reference' => $reference,
                'description' => $details,
                'user_id' => $user_id,
                'company_id' => $company_id,
                'phone_number' => $phone,
                'network' => $network,
                'discounted_amount' => $discounted_amount,
                'amount' => $amount,
                'real_amount' => $amount,

                'date' => $date,
                'time' => $time,
                'transaction_id' => $transaction_id,
            ]);
        } elseif ($title == 'Data Purchase') {
            SchedulePurchase::create([
                'title' => $title,
                'reference' => $reference,
                'description' => $details,
                'user_id' => $user_id,
                'company_id' => $company_id,
                'phone_number' => $phone,
                'network' => $network,
                'plan_id' => $discounted_amount,
                'amount' => $amount,

                'date' => $date,
                'time' => $time,
                'transaction_id' => $transaction_id,
            ]);
        } else {
            return false;
        }
        // return true;
        // dd($title,$reference,$details,$user_id,$phone,$network,$discounted_amount,$amount,$date,$time);

    }
    public function create_schedule_transaction($title, $reference, $details, $user_id, $phone, $network, $discounted_amount, $amount)
    {
        $user = Auth::user();
        $company_id = User::where('id', $user->company_id)->first()->id;
        if ($title == 'Airtime Purchase') {

            $tranx =  Transaction::create([
                'title' => $title,
                'reference' => $reference,
                'description' => $details,
                'user_id' => $user_id,
                'company_id' => $company_id,
                'type' => 'debit',
                'status' => 2,
                'phone_number' => $phone,
                'network' => $network,
                'discounted_amount' => $discounted_amount,
                'amount' => $amount,


            ]);
        } elseif ($title == 'Data Purchase') {
            $tranx =  Transaction::create([
                'title' => $title,
                'reference' => $reference,
                'description' => $details,
                'user_id' => $user_id,
                'company_id' => $company_id,
                'type' => 'debit',
                'status' => 2,
                'phone_number' => $phone,
                'network' => $network,
                'plan_id' => $discounted_amount,
                'amount' => $amount,


            ]);
        } else {
            return false;
        }
        return $tranx->id;
        // return true;
        // dd($title,$reference,$details,$user_id,$phone,$network,$discounted_amount,$amount,$date,$time);

    }

    public function run_schedule_purchase()
    {
        // dd($request->all());
        $currentDate = Carbon::now()->toDateString();
        $currentTime = Carbon::now()->toTimeString();


        $schedules = SchedulePurchase::where('status', 0)
            ->whereDate('date', $currentDate)
            ->whereTime('time', '>=', Carbon::parse($currentTime)->subMinutes(35))
            ->whereTime('time', '<=', $currentTime)
            ->get();
        // dd($schedules);
        foreach ($schedules as $schedule) {
            $tranx = Transaction::find($schedule->transaction_id);
            $user = User::find($tranx->user_id);
            if ($schedule->title == 'Data Purchase') {
                if ($user->upgrade == 1) {
                    $data = Data::where('user_id', $user->company_id)->where('plan_id', $tranx->plan_id)->where('network', $tranx->network)->first();
                } else {
                    $data = Data::where('user_id', 0)->where('plan_id', $tranx->plan_id)->where('network', $tranx->network)->first();
                }
                // $data = Data::where('user_id', $user->company_id)->where('plan_id', $tranx->plan_id)->where('network', $tranx->network)->first();
                // dd($data);
                if ($data == null) {
                    $tranx->status = 0;
                    $tranx->save();
                    $schedule->status = 2;
                    $schedule->save();
                    //in the future, there should be a mail notification here
                    return false;
                }
                $data_price =  $data->admin_price;
                $real_dataprice = $data->data_price;
                if ($user->balance < $data_price) {
                    $tranx->status = 0;
                    $tranx->save();
                    $schedule->status = 2;
                    $schedule->save();
                    //in the future, there should be a mail notification here
                    return false;
                }

                if ($data->network == 1) {
                    $network = 'MTN';
                } elseif ($data->network == 2) {
                    $network = 'GLO';
                } elseif ($data->network == 3) {
                    $network = "Airtel";
                } else {
                    $network = "9Mobile";
                }

                $details = $network . " Data Purchase of " . $data->plan_name . " on " . $tranx->phone_number;
                $client_reference =  'buy_data_' . Str::random(7);

                $check = $this->check_duplicate('check', $user->id, $data->data_price, "Data Purchase", $details, $client_reference);

                if ($check[0] == true) {
                    $tranx->status = 0;
                    $tranx->save();
                    $schedule->status = 2;
                    $schedule->save();

                    return false;
                }

                $trans_id = $this->create_transaction('Data Purchase', $client_reference, $details, 'debit', $data_price, $user->id, 2, $real_dataprice, $tranx->phone_number, $tranx->network, $tranx->plan_id);

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://easyaccessapi.com.ng/api/data.php",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => array(
                        'network' => $tranx->network,
                        'mobileno' => $tranx->phone_number,
                        'dataplan' => $tranx->plan_id,
                        'client_reference' => $client_reference, //update this on your script to receive webhook notifications
                    ),
                    CURLOPT_HTTPHEADER => array(
                        "AuthorizationToken: " . env('EASY_ACCESS_AUTH'), //replace this with your authorization_token
                        "cache-control: no-cache"
                    ),
                ));
                $schedule->status = 1;
                $schedule->save();
                $tranx->delete();
                $response = curl_exec($curl);
                curl_close($curl);
                return true;
            } elseif ($schedule->title == 'Airtime Purchase') {
                $phone_number = $tranx->phone_number;
                $actual_price = Airtime::where('user_id', $user->company_id)->where('network', $tranx->network)->first()->actual_price;
                $real_airtimeprice = $tranx->real_amount - ($actual_price / 100) * $tranx->real_amount;
                if ($user->balance < $tranx->amount) {
                    $tranx->status = 0;
                    $tranx->save();
                    $schedule->status = 2;
                    $schedule->save();
                    //in the future, there should be a mail notification here
                    return false;
                }
                $details =  "Airtime Purchase of " . $tranx->amount . " on " . $tranx->phone_number;
                $client_reference =   date('YmdH') . 'BA_' . Str::random(7);
                $check = $this->check_duplicate('check', $user->id, $tranx->amount, "Airtime Purchase", $details, $client_reference);

                if ($check[0] == true) {
                    $tranx->status = 0;
                    $tranx->save();
                    $schedule->status = 2;
                    $schedule->save();
                    return false;
                }



                if ($tranx->network == 1 || $tranx->network == 'MTN') {
                    $network = 'MTN';
                } elseif ($tranx->network == 2 || $tranx->network == 'GLO') {
                    $network = 'GLO';
                } elseif ($tranx->network == 3 || $tranx->network == 'AIRTEL') {
                    $network = 'AIRTEL';
                } else {
                    $network = '9MOBILE';
                }

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('TELNETINGTOKEN'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])->post('https://telneting.com/api/airtime/buy', [
                    'network' => $network,
                    'phone' => $phone_number,
                    'amount' => $tranx->amount,
                    'reference' => $client_reference, //update this on your script to receive webhook notifications

                ]);
                $response_json = json_decode($response, true);




                if ($response_json['status_code'] == 100) {
                    file_put_contents(__DIR__ . '/telnetingairtime.txt', json_encode($response_json, JSON_PRETTY_PRINT), FILE_APPEND);

                    $trans_id = $this->create_transaction('Airtime Purchase', $client_reference, $details, 'debit', $tranx->discounted_amount, $user->id, 1, $real_airtimeprice, $phone_number, $network, $tranx->amount);

                    // Transaction was successful
                    // Do something here
                } else {
                    $reference = 'failed_tv_' . Str::random(5);
                    $details = "Failed Airitime Purchase, amount: " . $tranx->discounted_amount;
                    $trans_id = $this->create_transaction('Airtime Purchase', $client_reference, $details, 'debit', $tranx->discounted_amount, $user->id, 0, $real_airtimeprice, $phone_number, $network, $tranx->amount);
                }
                $this->check_duplicate("Delete", $user->id);
                $response_json['success'] = 'true';
                // return $response_json;



                //this is for easyaccess
                // $trans_id = $this->create_transaction('Airtime Purchase', $client_reference, $details, 'debit', $tranx->discounted_amount, $user->id, 1, $real_airtimeprice, $phone_number, $tranx->network, $tranx->real_amount);
                // $curl = curl_init();
                // curl_setopt_array($curl, array(
                //     CURLOPT_URL => "https://easyaccessapi.com.ng/api/airtime.php",
                //     CURLOPT_RETURNTRANSFER => true,
                //     CURLOPT_ENCODING => "",
                //     CURLOPT_MAXREDIRS => 10,
                //     CURLOPT_TIMEOUT => 0,
                //     CURLOPT_FOLLOWLOCATION => true,
                //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                //     CURLOPT_CUSTOMREQUEST => "POST",
                //     CURLOPT_POSTFIELDS => array(
                //         'network' => $tranx->network,
                //         'mobileno' => $phone_number,
                //         'amount' => $tranx->amount,
                //         'airtime_type' => 001,
                //         'client_reference' => $client_reference, //update this on your script to receive webhook notifications
                //     ),
                //     CURLOPT_HTTPHEADER => array(
                //         "AuthorizationToken: " . env('EASY_ACCESS_AUTH'), //replace this with your authorization_token
                //         "cache-control: no-cache"
                //     ),
                // ));
                // $response = curl_exec($curl);

                $schedule->status = 1;
                $schedule->save();
                $tranx->delete;

                // curl_close($curl);
                return true;
            } else {
                $tranx->status = 0;
                $tranx->save();
                $schedule->status = 2;
                $schedule->save();
                //in the future, there should be a mail notification here
                return false;
            }
        }
    }
    public function run_data_giveaway()
    {
        // dd($request->all());
        $tenMinutesAgo = Carbon::now()->subMinutes(10);
        $recipients = GiveawaySchedule::where('status', 0)
            ->where('created_at', '>=', $tenMinutesAgo)
            ->get();
        // dd($recipients);
        $purchase_status = [];
        foreach ($recipients as $reci) {
            if ($reci->type == 'data') {
                $response = $this->handle_buy_data($reci->phone, $reci->network, $reci->plan_id, $reci->giveaway_id, $reci->participant_id);
                // if($response['success'] === "true") {
                //     $reci->status = 1;
                //     $reci->save();
                // }

            } elseif ($reci->type == 'airtime') {
                $response = $this->handle_buy_airtime($reci->phone, $reci->network, $reci->amount, $reci->amount, $reci->giveaway_id, $reci->participant_id);
                // if($response['success'] === "true") {
                //     $reci->status = 1;
                //     $reci->save();
                // }
            } else {

                return true;
            }
            // dd($reci, $response);
            if (is_object($response) && method_exists($response, 'getData')) {
                $responseData = $response->getData();

                if (is_object($responseData) && property_exists($responseData, 'success') && $responseData->success === false) {
                    if (!is_object($response) || !property_exists($responseData, 'type') || $responseData->type === 'duplicate') {
                        $response = [
                            'success' => false,
                            'message' => 'Please kindly clear your pending transactions before proceeding',
                            'auto_refund_status' => 'Nil',
                            'data' => $purchase_status,
                        ];
                        return response()->json($response);
                    }
                }
            }

            array_push($purchase_status, $response);
        }

        $response = [
            'success' => true,
            'message' => 'Purchase Successful! Check group transaction table to confirm. ',
            'auto_refund_status' => 'Nil',
            'data' => $purchase_status,
        ];

        return response()->json($response);
        // return [$purchase_status,true];
    }

    private function handle_buy_data($phone, $network, $plan_id, $group_id = null, $part_id = null)
    {

        $phone_number = $phone;
        if (strlen($phone) == 10) {
            $phone_number = "0" . $phone;
        }

        $data = Data::where('user_id', 0)->where('plan_id', $plan_id)->where('network', $network)->first();
        $data_price =  $data->admin_price;
        $real_dataprice = $data->data_price;
        if ($data == null) {
            $response = [
                'success' => false,
                'message' => 'Invalid Plan!',
                'auto_refund_status' => 'Nil'
            ];

            return response()->json($response);
        }
        //check balance
        if ($data->network == 1) {
            $network_mi = 'MTN';
        } elseif ($data->network == 2) {
            $network_mi = 'GLO';
        } elseif ($data->network == 3) {
            $network_mi = "Airtel";
        } else {
            $network_mi = "9Mobile";
        }
        $details = $network_mi . " Data Purchase of " . $data->plan_name . " on " . $phone;
        $client_reference =  'sgw_buy_data_' . Str::random(5);

        $recipient = GiveawaySchedule::where('participant_id', $part_id)->first();
        if ($recipient !== null) {
            $recipient->reference = $client_reference;
            $recipient->save();
        }

        //purchase the data

        $trans_id = $this->create_transaction('Data Purchase', $client_reference, $details, 'debit', $data_price, 5, 2, $real_dataprice);
        $transaction = Transaction::find($trans_id);
        $transaction->group_id = $group_id;
        $transaction->save();

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://easyaccessapi.com.ng/api/data.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'network' => $network,
                'mobileno' => $phone_number,
                'dataplan' => $plan_id,
                'client_reference' => $client_reference, //update this on your script to receive webhook notifications
            ),
            CURLOPT_HTTPHEADER => array(
                "AuthorizationToken: " . env('EASY_ACCESS_AUTH'), //replace this with your authorization_token
                "cache-control: no-cache"
            ),
        ));
        $response = curl_exec($curl);
        $response_json = json_decode($response, true);
        curl_close($curl);
        return $response_json;
    }

    public function handle_buy_airtime($phone, $network, $amount, $discounted_amount, $group_id = null, $part_id = null)
    {
        $phone_number = $phone;
        if (strlen($phone) == 10) {
            $phone_number = "0" . $phone;
        }

        // dd($request->all());
        $actual_price = Airtime::where('network', $network)->where('user_id', 0)->first()->airtime_price;
        $real_airtimeprice = $amount - ($actual_price / 100) * $amount;
        // dd($real_airtimeprice, $actual_price);



        //check duplicate

        $details =  "Airtime Purchase of " . $amount . " on " . $phone;
        $client_reference =  'sgw_buy_airtime_' . Str::random(7);
        $recipient = GiveawaySchedule::where('participant_id', $part_id)->first();
        if ($recipient !== null) {
            $recipient->reference = $client_reference;
            $recipient->save();
        }

        //purchase the airtime


        $details =  "Airtime Purchase of " . $amount . " on " . $phone;
        $client_reference =   date('YmdH') . 'BA_' . Str::random(7);
        if ($network == 1 || $network == 'MTN') {
            $network = 'MTN';
        } elseif ($network == 2 || $network == 'GLO') {
            $network = 'GLO';
        } elseif ($network == 3 || $network == 'AIRTEL') {
            $network = 'AIRTEL';
        } else {
            $network = '9MOBILE';
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env("TELNETINGTOKEN"),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://telneting.com/api/airtime/buy', [
            'network' => $network,
            'phone' => $phone_number,
            'amount' => $amount,
            'reference' => $client_reference, //update this on your script to receive webhook notifications

        ]);
        $response_json = json_decode($response, true);

        if ($response_json['status_code'] == 100) {
            file_put_contents(__DIR__ . '/telnetingairtime.txt', json_encode($response_json, JSON_PRETTY_PRINT), FILE_APPEND);

            $trans_id = $this->create_transaction('Airtime Purchase', $client_reference, $details, 'debit', $discounted_amount, 5, 1, $real_airtimeprice, $phone, $network, $amount);
            $transaction = Transaction::find($trans_id);
            $transaction->group_id = $group_id;
            $transaction->save();
            // Transaction was successful
            // Do something here
        } else {
            $reference = 'failed_tv_' . Str::random(5);
            $details = "Failed Airitime Purchase, amount: " . $discounted_amount;
            $trans_id = $this->create_transaction('Airtime Purchase', $client_reference, $details, 'debit', $discounted_amount, 5, 0, $real_airtimeprice, $phone_number, $network, $amount);
        }
        $response_json['success'] = 'true';
        return $response_json;
        //this for easyaccess
        // $trans_id = $this->create_transaction('Airtime Purchase', $client_reference, $details, 'debit', $discounted_amount, 5, 2, $real_airtimeprice, $phone, $network, $amount);
        // $transaction = Transaction::find($trans_id);
        // $transaction->group_id = $group_id;
        // $transaction->save();
        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://easyaccessapi.com.ng/api/airtime.php",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => array(
        //         'network' => $network,
        //         'mobileno' => $phone_number,
        //         'amount' => $amount,
        //         'airtime_type' => 001,
        //         'client_reference' => $client_reference, //update this on your script to receive webhook notifications
        //     ),
        //     CURLOPT_HTTPHEADER => array(
        //         // "AuthorizationToken: " . $env, //replace this with your authorization_token
        //         "AuthorizationToken: " . env('EASY_ACCESS_AUTH'), //replace this with your authorization_token
        //         "cache-control: no-cache"
        //     ),
        // ));
        // $response = curl_exec($curl);
        // $response_json = json_decode($response, true);

        // curl_close($curl);
        // return $response_json;
    }
}
