<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\LoanPaymentTracker;
use App\Models\MemberLoan;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payaza_webhook(Request $request)
    {
        file_put_contents(__DIR__ . '/payaza.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);
    }
    public function payaza_callback(Request $request)
    {
        file_put_contents(__DIR__ . '/paycallback.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);
    }
    public function oldoldpayment_webhook(Request $request)
    {
        file_put_contents(__DIR__ . '/flutterwave_payment.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);
    }

    public function payment_webhook(Request $request)
    {
        // Log the webhook data
        file_put_contents(__DIR__ . '/flutterwave_payment3.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);

        // Verify the payment data
        // $email = $request->input('customer.email');
        $email = 'member@syncosave.com';
        $amountPaid = intval($request->input('amount'));
        $reference = $request->input('id');

        // Find the user
        $user = User::where('email', $email)->firstOrFail();
        $company = Company::where('uuid', $user->company_id)->first();

        // Check for pending registration fee
        $hasRegFee = false;
        if (intval($company->reg_fee) > 0) {
            $regFeePaid = Transaction::where('user_id', $user->uuid)
                ->where('status', 'Success')
                ->where('payment_type', 'Registration')
                ->exists();

            if (!$regFeePaid && $amountPaid >= intval($company->reg_fee)) {
                // Create registration fee transaction
                Transaction::create([
                    'user_id' => $user->uuid,
                    'company_id' => $company->uuid,
                    'amount' => $company->reg_fee,
                    'transaction_id' => $reference,
                    'status' => 'Success',
                    'payment_type' => 'Registration',
                    'email' => $email
                ]);

                $amountPaid -= intval($company->reg_fee);
                $hasRegFee = true;
            }
        }

        // Process remaining amount based on company type
        if ($company->type == 2) { // Contribution type
            // Get pending contribution dues
            // $pendingDues = Group::whereIn('id', 
            //     GroupMember::where('user_id', $user->id)
            //         ->select('group_id')
            //         ->distinct()
            //         ->pluck('group_id')
            //         ->toArray()
            // )
            // ->where('status', 1)
            // ->get()
            // ->map(function($group) use ($user) {
            //     return [
            //         'amount' => $group->amount,
            //         'uuid' => $group->uuid,
            //         'title' => $group->title
            //     ];
            // })
            // ->toArray();
            $pendingDues = $this->getPendingContributions($user);

            // Settle dues if amount matches
            foreach ($pendingDues as $due) {
                if ($amountPaid >= $due['amount']) {
                    Transaction::create([
                        'user_id' => $user->uuid,
                        'company_id' => $company->uuid,
                        'amount' => $due['amount'],
                        'transaction_id' => $reference,
                        'status' => 'Success',
                        'payment_type' => 'Contribution',
                        'uuid' => $due['uuid'],
                        'month' => $due['month'] ?? null,
                        'week' => $due['week'] ?? null,
                        'day' => $due['day'] ?? null,  // Add this line
                        'email' => $email
                    ]);
                    $amountPaid -= $due['amount'];
                }
            }
        } else { // Cooperative type

            //check loan payment form
           

            $loan_application_fee = LoanPaymentTracker::where('user_id', $user->uuid)->where('status', 0)->where('type', 'repayment')->first();
            if ($loan_application_fee) {
                $pendingLoans = MemberLoan::where([
                    ['user_id', $user->uuid], // Use uuid consistently
                    ['status', 'Ongoing']
                ])->get();

                if ($amountPaid >= $loan_application_fee->amount) {
                    foreach ($pendingLoans as $loan) {
                        // Get all unpaid months for this loan
                        $loanStartDate = Carbon::parse($loan->disbursed_date);
                        $currentDate = Carbon::now();
                        $unpaidMonths = [];
                        
                        while ($loanStartDate->lessThanOrEqualTo($currentDate)) {
                            $monthFormat = $loanStartDate->format('F Y');
                            
                            // Check if this month is already paid
                            $isPaid = Transaction::where([
                                'user_id' => $user->uuid,
                                'uuid' => $loan->uuid,
                                'payment_type' => 'Repayment',
                                'status' => 'Success',
                                'month' => $monthFormat
                            ])->exists();
                            
                            if (!$isPaid) {
                                $unpaidMonths[] = $monthFormat;
                            }
                            
                            $loanStartDate->addMonth();
                        }
                        
                        // Process payments for unpaid months in chronological order
                        foreach ($unpaidMonths as $month) {
                            if ($amountPaid >= $loan_application_fee->amount) {
                                Transaction::create([
                                    'user_id' => $user->uuid,
                                    'company_id' => $company->uuid,
                                    'amount' => $loan->monthly_return,
                                    'transaction_id' => $reference,
                                    'status' => 'Success',
                                    'payment_type' => 'Repayment',
                                    'month' => "Pelxz",
                                    'uuid' => $loan->uuid,
                                    'email' => $email
                                ]);
                                $amountPaid -= $loan->monthly_return;
                            } else {
                                break; // Not enough money for next payment
                            }
                        }
                    }
                    $loan_application_fee->update([
                        'status' => 1
                    ]);
                }
            }



            // check loan repayment

            $loan_application_fee = LoanPaymentTracker::where('user_id', $user->uuid)->where('status', 0)->where('type', 'repayment')->first();
            if ($loan_application_fee) {

                $pendingLoans = MemberLoan::where([
                    ['user_id', $user->id],
                    ['status', 'Ongoing']
                ])->get();

                if ($amountPaid >= $loan_application_fee->amount) {
                    foreach ($pendingLoans as $loan) {
                        if ($amountPaid >= $loan->monthly_return) {
                            Transaction::create([
                                'user_id' => $user->uuid,
                                'company_id' => $company->uuid,
                                'amount' => $loan->monthly_return,
                                'transaction_id' => $reference,
                                'status' => 'Success',
                                'payment_type' => 'Repayment',
                                // 'month' => $loan['month'] ?? null,
                                // 'week' => $loan['week'] ?? null,
                                'uuid' => $loan->uuid,
                                'email' => $email
                            ]);
                            $amountPaid -= $loan->monthly_return;
                        }
                    }
                    $loan_application_fee->update([
                        'status' => 1
                    ]);
                }
            }
            // 1. Check cooperative dues

            $pendingCoopDues = $this->getPendingCoopDues($user);
            foreach ($pendingCoopDues as $due) {
                if ($amountPaid >= $due['amount']) {
                    Transaction::create([
                        'user_id' => $user->uuid,
                        'company_id' => $company->uuid,
                        'amount' => $due['amount'],
                        'transaction_id' => $reference,
                        'status' => 'Success',
                        'payment_type' => 'Cooperative-Dues',
                        'month' => $due['month'] ?? null,
                        'week' => $due['week'] ?? null,
                        'email' => $email
                    ]);
                    $amountPaid -= $due['amount'];
                }
            }

            // 2. Check contribution dues
            if ($amountPaid > 0) {
                $pendingContributions = $this->getPendingContributions($user);
                foreach ($pendingContributions as $contribution) {
                    if ($amountPaid >= $contribution['amount']) {
                        Transaction::create([
                            'user_id' => $user->uuid,
                            'company_id' => $company->uuid,
                            'amount' => $contribution['amount'],
                            'transaction_id' => $reference,
                            'status' => 'Success',
                            'payment_type' => 'Contribution',
                            'month' => $contribution['month'] ?? null,
                            'week' => $contribution['week'] ?? null,
                            'day' => $contribution['day'] ?? null,
                            'uuid' => $contribution['uuid'],
                            'email' => $email
                        ]);
                        $amountPaid -= $contribution['amount'];
                    }
                }
            }

            // 3. Check loan repayments
            if ($amountPaid > 0) {
                $pendingLoans = MemberLoan::where([
                    ['user_id', $user->id],
                    ['status', 'Ongoing']
                ])->get();

                foreach ($pendingLoans as $loan) {
                    if ($amountPaid >= $loan->monthly_return) {
                        Transaction::create([
                            'user_id' => $user->uuid,
                            'company_id' => $company->uuid,
                            'amount' => $loan->monthly_return,
                            'transaction_id' => $reference,
                            'status' => 'Success',
                            'payment_type' => 'Repayment',
                            'month' => 'Jan',
                            // 'month' => $loan['month'] ?? null,
                            // 'week' => $loan['week'] ?? null,
                            'uuid' => $loan->uuid,
                            'email' => $email
                        ]);
                        $amountPaid -= $loan->monthly_return;
                    }
                }
            }
        }

        return response()->json('OK', 200);
    }



    public function new_payment_webhook(Request $request)
    {
        $logPath = __DIR__ . '/webhook_logs/';
        if (!file_exists($logPath)) {
            mkdir($logPath, 0777, true);
        }

        // Log initial request
        file_put_contents(
            $logPath . 'initial_request.txt',
            json_encode($request->all(), JSON_PRETTY_PRINT),
            FILE_APPEND
        );

        try {
            // Log payment data extraction
            $email = $request->input('customer.email');
            $amountPaid = intval($request->input('amount'));
            $reference = $request->input('id');
            $status = $request->input('status');

            file_put_contents(
                $logPath . 'payment_data.txt',
                json_encode([
                    'timestamp' => now(),
                    'email' => $email,
                    'amount' => $amountPaid,
                    'reference' => $reference,
                    'status' => $status
                ], JSON_PRETTY_PRINT),
                FILE_APPEND
            );

            // Verify transaction status
            if ($status !== 'successful') {
                file_put_contents(
                    $logPath . 'failed_status.txt',
                    "Payment not successful. Status: $status",
                    FILE_APPEND
                );
                return response()->json('Payment not successful', 400);
            }

            // Find user
            $user = User::where('email', $email)->first();
            if (!$user) {
                file_put_contents(
                    $logPath . 'user_error.txt',
                    "User not found for email: $email",
                    FILE_APPEND
                );
                return response()->json('User not found', 404);
            }

            file_put_contents(
                $logPath . 'user_found.txt',
                json_encode([
                    'user_id' => $user->id,
                    'email' => $user->email
                ], JSON_PRETTY_PRINT),
                FILE_APPEND
            );

            // Get company
            $company = Company::where('uuid', $user->company_id)->first();
            if (!$company) {
                file_put_contents(
                    $logPath . 'company_error.txt',
                    "Company not found for user: $user->id",
                    FILE_APPEND
                );
                return response()->json('Company not found', 404);
            }

            file_put_contents(
                $logPath . 'company_found.txt',
                json_encode([
                    'company_id' => $company->id,
                    'reg_fee' => $company->reg_fee,
                    'type' => $company->type
                ], JSON_PRETTY_PRINT),
                FILE_APPEND
            );

            // Check registration fee
            $hasRegFee = false;
            if ($company->reg_fee > 0) {
                $regFeePaid = Transaction::where('user_id', $user->uuid)
                    ->where('status', 'Success')
                    ->where('payment_type', 'Registration')
                    ->exists();

                file_put_contents(
                    $logPath . 'reg_fee_check.txt',
                    json_encode([
                        'has_reg_fee' => true,
                        'reg_fee_amount' => $company->reg_fee,
                        'already_paid' => $regFeePaid,
                        'amount_paid' => $amountPaid,
                        'can_pay_reg_fee' => (!$regFeePaid && $amountPaid >= $company->reg_fee)
                    ], JSON_PRETTY_PRINT),
                    FILE_APPEND
                );

                if (!$regFeePaid && $amountPaid >= $company->reg_fee) {
                    try {
                        Transaction::create([
                            'user_id' => $user->uuid,
                            'company_id' => $company->id,
                            'amount' => $company->reg_fee,
                            'transaction_id' => $reference,
                            'status' => 'Success',
                            'payment_type' => 'Registration',
                            'email' => $email
                        ]);

                        file_put_contents(
                            $logPath . 'reg_fee_paid.txt',
                            "Registration fee successfully paid",
                            FILE_APPEND
                        );

                        $amountPaid -= $company->reg_fee;
                        $hasRegFee = true;
                    } catch (\Exception $e) {
                        file_put_contents(
                            $logPath . 'reg_fee_error.txt',
                            "Error saving registration fee: " . $e->getMessage(),
                            FILE_APPEND
                        );
                    }
                }
            }

            // Process remaining amount
            file_put_contents(
                $logPath . 'remaining_amount.txt',
                "Remaining amount to process: $amountPaid",
                FILE_APPEND
            );

            // Continue with existing logic for processing remaining amount...
            // [Previous code for processing contribution/cooperative payments remains the same]

            file_put_contents(
                $logPath . 'process_complete.txt',
                "Payment processing completed successfully",
                FILE_APPEND
            );

            return response()->json('OK', 200);
        } catch (\Exception $e) {
            file_put_contents(
                $logPath . 'error_log.txt',
                "Error processing payment: " . $e->getMessage() . "\n" .
                    "Stack trace: " . $e->getTraceAsString(),
                FILE_APPEND
            );

            return response()->json('Internal server error', 500);
        }
    }


    private function getPendingCoopDues($user)
    {
        $startDate = Carbon::parse($user->created_at);
        $endDate = Carbon::now();
        $mode = $user->plan()->mode;
        $pendingDues = [];

        if ($mode == 'Monthly') {
            $currentDate = $startDate->copy()->startOfMonth();
            while ($currentDate->lte($endDate)) {
                $month = $currentDate->format('F Y');
                $paid = Transaction::where('user_id', $user->uuid)
                    ->where([
                        ['status', 'Success'],
                        ['payment_type', 'Cooperative-Dues'],
                        ['month', $month]
                    ])->exists();

                if (!$paid) {
                    $pendingDues[] = [
                        'month' => $month,
                        'amount' => $user->plan()->dues,
                        'period_type' => 'month'
                    ];
                }
                $currentDate->addMonth();
            }
        } elseif ($mode == 'Weekly') {
            $currentDate = $startDate->copy()->startOfWeek();
            while ($currentDate->lte($endDate)) {
                $weekStart = $currentDate->format('M d');
                $weekEnd = $currentDate->copy()->endOfWeek()->format('M d, Y');
                $weekFormat = "$weekStart - $weekEnd";

                $paid = Transaction::where('user_id', $user->uuid)
                    ->where([
                        ['status', 'Success'],
                        ['payment_type', 'Cooperative-Dues'],
                        ['week', $weekFormat]
                    ])->exists();

                if (!$paid) {
                    $pendingDues[] = [
                        'week' => $weekFormat,
                        'amount' => $user->plan()->dues,
                        'period_type' => 'week'
                    ];
                }
                $currentDate->addWeek();
            }
        }

        return $pendingDues;
    }

    private function oldgetPendingContributions($user)
    {
        return Group::whereIn(
            'id',
            GroupMember::where('user_id', $user->id)
                ->select('group_id')
                ->distinct()
                ->pluck('group_id')
                ->toArray()
        )
            ->where('status', 1)
            ->get()
            ->map(function ($group) use ($user) {
                return [
                    'amount' => $group->amount,
                    'uuid' => $group->uuid,
                    'title' => $group->title,

                ];
            })
            ->toArray();
    }

    private function getPendingContributions($user)
    {
        $groups = Group::whereIn(
            'id',
            GroupMember::where('user_id', $user->id)
                ->select('group_id')
                ->distinct()
                ->pluck('group_id')
                ->toArray()
        )
            ->where('status', 1)
            ->get();

        $pendingContributions = [];
        foreach ($groups as $group) {
            $startDate = Carbon::parse($group->start_date);
            $endDate = Carbon::now();

            if ($group->mode == "Daily") {
                $currentDate = $startDate->copy()->startOfDay();
                while ($currentDate->lte($endDate)) {
                    $dayFormat = $currentDate->format('F d, Y');

                    // Check if payment exists for this day
                    $paid = Transaction::where([
                        ['user_id', $user->uuid],
                        ['status', 'Success'],
                        ['payment_type', 'Contribution'],
                        ['uuid', $group->uuid],
                        ['day', $dayFormat]
                    ])->exists();

                    if (!$paid) {
                        $pendingContributions[] = [
                            'amount' => $group->amount,
                            'uuid' => $group->uuid,
                            'title' => $group->title,
                            'month' => null,
                            'week' => null,
                            'day' => $dayFormat,
                            'mode' => 'Daily',
                            'period' => $dayFormat
                        ];
                    }
                    $currentDate->addDay();
                }
            } elseif ($group->mode == "Weekly") {
                $currentDate = $startDate->copy()->startOfWeek();
                while ($currentDate->lte($endDate)) {
                    $weekStart = $currentDate->format('M d');
                    $weekEnd = $currentDate->copy()->endOfWeek()->format('M d, Y');
                    $weekFormat = "$weekStart - $weekEnd";

                    // Check if payment exists for this week
                    $paid = Transaction::where([
                        ['user_id', $user->uuid],
                        ['status', 'Success'],
                        ['payment_type', 'Contribution'],
                        ['uuid', $group->uuid],
                        ['week', $weekFormat]
                    ])->exists();

                    if (!$paid) {
                        $pendingContributions[] = [
                            'amount' => $group->amount,
                            'uuid' => $group->uuid,
                            'title' => $group->title,
                            'week' => $weekFormat,
                            'month' => null,
                            'mode' => 'Weekly',
                            'period' => $weekFormat
                        ];
                    }
                    $currentDate->addWeek();
                }
            } elseif ($group->mode == "Monthly") {
                $currentDate = $startDate->copy()->startOfMonth();
                while ($currentDate->lte($endDate)) {
                    $monthFormat = $currentDate->format('F Y');

                    // Check if payment exists for this month
                    $paid = Transaction::where([
                        ['user_id', $user->uuid],
                        ['status', 'Success'],
                        ['payment_type', 'Contribution'],
                        ['uuid', $group->uuid],
                        ['month', $monthFormat]
                    ])->exists();

                    if (!$paid) {
                        $pendingContributions[] = [
                            'amount' => $group->amount,
                            'uuid' => $group->uuid,
                            'title' => $group->title,
                            'month' => $monthFormat,
                            'week' => null,
                            'mode' => 'Monthly',
                            'period' => $monthFormat
                        ];
                    }
                    $currentDate->addMonth();
                }
            }
        }

        // Sort by date (oldest first)
        usort($pendingContributions, function ($a, $b) {
            $aDate = $a['month'] ? Carbon::parse($a['month']) : Carbon::parse(explode(' - ', $a['week'])[0]);
            $bDate = $b['month'] ? Carbon::parse($b['month']) : Carbon::parse(explode(' - ', $b['week'])[0]);
            return $aDate->timestamp - $bDate->timestamp;
        });

        return $pendingContributions;
    }
    public function callback_webhook(Request $request)
    {
        file_put_contents(__DIR__ . '/paycallback.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);
    }
}
