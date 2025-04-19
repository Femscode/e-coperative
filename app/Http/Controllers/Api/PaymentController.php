<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\MemberLoan;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payaza_webhook(Request $request) {
        file_put_contents(__DIR__ . '/payaza.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);
        
    }
    public function payaza_callback(Request $request) {
        file_put_contents(__DIR__ . '/paycallback.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);

    }
    public function oldpayment_webhook(Request $request) {
        file_put_contents(__DIR__ . '/flutterwave_payment.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);
        
    }

    public function payment_webhook(Request $request) {
        // Log the webhook data
        file_put_contents(__DIR__ . '/flutterwave_payment2.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);
        
        // Verify the payment data
        $email = $request->input('customer.email');
        $amountPaid = intval($request->input('amount'));
        $reference = $request->input('id');
        
        // Find the user
        $user = User::where('email', $email)->firstOrFail();
        $company = Company::where('uuid', $user->company_id)->first();
        
        // Check for pending registration fee
        $hasRegFee = false;
        if ($company->reg_fee > 0) {
            $regFeePaid = Transaction::where('user_id', $user->uuid)
                ->where('status', 'Success')
                ->where('payment_type', 'Registration')
                ->exists();
                
            if (!$regFeePaid && $amountPaid >= $company->reg_fee) {
                // Create registration fee transaction
                Transaction::create([
                    'user_id' => $user->uuid,
                    'company_id' => $company->id,
                    'amount' => $company->reg_fee,
                    'transaction_id' => $reference,
                    'status' => 'Success',
                    'payment_type' => 'Registration',
                    'email' => $email
                ]);
                
                $amountPaid -= $company->reg_fee;
                $hasRegFee = true;
            }
        }

        // Process remaining amount based on company type
        if ($company->type == 2) { // Contribution type
            // Get pending contribution dues
            $pendingDues = Group::whereIn('id', 
                GroupMember::where('user_id', $user->id)
                    ->select('group_id')
                    ->distinct()
                    ->pluck('group_id')
                    ->toArray()
            )
            ->where('status', 1)
            ->get()
            ->map(function($group) use ($user) {
                return [
                    'amount' => $group->amount,
                    'uuid' => $group->uuid,
                    'title' => $group->title
                ];
            })
            ->toArray();

            // Settle dues if amount matches
            foreach ($pendingDues as $due) {
                if ($amountPaid >= $due['amount']) {
                    Transaction::create([
                        'user_id' => $user->uuid,
                        'company_id' => $company->id,
                        'amount' => $due['amount'],
                        'transaction_id' => $reference,
                        'status' => 'Success',
                        'payment_type' => 'Contribution',
                        'uuid' => $due['uuid'],
                        'email' => $email
                    ]);
                    $amountPaid -= $due['amount'];
                }
            }
        } else { // Cooperative type
            // 1. Check cooperative dues
            $pendingCoopDues = $this->getPendingCoopDues($user);
            foreach ($pendingCoopDues as $due) {
                if ($amountPaid >= $due['amount']) {
                    Transaction::create([
                        'user_id' => $user->uuid,
                        'company_id' => $company->id,
                        'amount' => $due['amount'],
                        'transaction_id' => $reference,
                        'status' => 'Success',
                        'payment_type' => 'Monthly Dues',
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
                            'company_id' => $company->id,
                            'amount' => $contribution['amount'],
                            'transaction_id' => $reference,
                            'status' => 'Success',
                            'payment_type' => 'Contribution',
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
                            'company_id' => $company->id,
                            'amount' => $loan->monthly_return,
                            'transaction_id' => $reference,
                            'status' => 'Success',
                            'payment_type' => 'Repayment',
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

    private function getPendingCoopDues($user) {
        $startDate = Carbon::parse($user->created_at);
        $endDate = Carbon::now();
        $mode = $user->plan()->mode;
        $pendingDues = [];

        if ($mode == 'Monthly') {
            $currentDate = $startDate->copy()->startOfMonth();
            while ($currentDate->lte($endDate)) {
                $month = $currentDate->format('F Y');
                $paid = Transaction::where('user_id', $user->id)
                    ->where([
                        ['status', 'Success'],
                        ['payment_type', 'Monthly Dues'],
                        ['month', $month]
                    ])->exists();
                
                if (!$paid) {
                    $pendingDues[] = [
                        'month' => $month,
                        'amount' => $user->plan()->amount
                    ];
                }
                $currentDate->addMonth();
            }
        }
        // Add similar logic for Weekly mode if needed

        return $pendingDues;
    }

    private function getPendingContributions($user) {
        return Group::whereIn('id', 
            GroupMember::where('user_id', $user->id)
                ->select('group_id')
                ->distinct()
                ->pluck('group_id')
                ->toArray()
        )
        ->where('status', 1)
        ->get()
        ->map(function($group) use ($user) {
            return [
                'amount' => $group->amount,
                'uuid' => $group->uuid,
                'title' => $group->title
            ];
        })
        ->toArray();
    }
    public function callback_webhook(Request $request) {
        file_put_contents(__DIR__ . '/paycallback.txt', json_encode($request->all(), JSON_PRETTY_PRINT), FILE_APPEND);

    }
}
