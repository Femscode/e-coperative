<?php

namespace App\Http\Controllers\Admin;
use App\Models\MemberLoan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use Illuminate\Support\Str;
use Unicodeveloper\Paystack\Paystack;
use Unicodeveloper\Paystack\Facades\Paystack as PaystackFacade;
use GuzzleHttp\Client;
class LoanController extends Controller
{
    public function index(){
        $data['title'] = "Loan Applications";
        return view('dashboard.loan', $data);
        return view('admin.loan.index', $data);
    }

    public function approve(Request $request){
        try {
            $input = $request->all();
            $application = MemberLoan::find($request->id);
            $uuid = Str::random(8);
            $application->update(['approval_status' => 1, 'uuid' => $uuid]);
                return api_request_response(
                    'ok',
                    'Application approved successfully!',
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

    public function disburse(Request $request){
        try {
            $apiSecret = env('PAYSTACK_DISBURSE_SECRET_KEY');
            $client = new Client();
            // $paystack = new Paystack();
            $loanDetails = MemberLoan::where('id', $request->id)->first();
            $user = $loanDetails->user();
            $name = $user->account_name;
            $code = $user->bank_code;
            $number = $user->account_number;
            $response = $client->post('https://api.paystack.co/transferrecipient', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiSecret,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'type' => 'nuban',
                    'name' => $name,
                    'description' => 'Recipient Description',
                    'account_number' => $number,
                    'bank_code' => $code,
                ],
            ]);

            $responseData = json_decode($response->getBody());

            if ($responseData->status) {
                // Recipient created successfully
                $recipientCode = $responseData->data->recipient_code;
                $client = new Client();

                $response = $client->post('https://api.paystack.co/transfer', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $apiSecret,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'recipient' => $recipientCode,
                        'amount' =>  $loanDetails->total_applied * 100, // Amount in kobo (e.g., 10000 for ₦100)
                        'source' => 'balance', // Amount in kobo (e.g., 10000 for ₦100)
                    ],
                ]);
                $responseData = json_decode($response->getBody());
                if ($responseData->status) {
                    // Transfer initiated successfully
                    $loanDetails->update(['released' => 1, 'status' => "Ongoing","disbursed_date" => now()]);
                    // You can save the transfer reference and status in your database for tracking
                    return api_request_response(
                        'ok',
                        'Transfer initiated successfully!',
                        success_status_code(),
                    );
                    // return redirect()->back()->with('success', 'Transfer initiated successfully');
                } else {
                    // Handle the error
                    return api_request_response(
                        'error',
                        $responseData->message,
                        bad_response_status_code()
                    );
                    // return redirect()->back()->with('error', $transfer->data->message);
                }

                // return redirect()->back()->with('success', 'Recipient created successfully');
            } else {
                // Handle the error
                return api_request_response(
                    'error',
                    $responseData->message,
                    bad_response_status_code()
                );
                // return redirect()->back()->with('error', $recipient->data->message);
            }
        } catch (\Exception $exception) {
            return api_request_response(
                'error',
                $exception->getMessage(),
                bad_response_status_code()
            );
        }
    }
}