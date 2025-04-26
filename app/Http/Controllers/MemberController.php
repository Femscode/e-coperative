<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\MemberLoan;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $date = date('Y-m-d', strtotime(Auth::user()->created_at));
        $data['now'] = Carbon::now();

        $data['user'] = $user = Auth::user();
        $data['member_loan'] = MemberLoan::where('user_id', $user->id)->where('approval_status', 1)->get();
        $data['transactions'] = Transaction::where('user_id', $user->id)->orWhere('email', $user->email)->where('status', 'Success')->latest()->paginate(10);
        $data['company'] = $company = Company::where('uuid', $user->company_id)->first();

        $userCompany = Company::where('uuid', $user->company_id)->first();
        if ($userCompany->type == 2) {

            return view('ajo.member.index', $data);
        } else {
            return view('cooperative.member.index', $data);
        }
    }

    public function reg_fee(Request $request)
    {
        $user = Auth::user();
        $company = Company::where('uuid', $user->company_id)->first();

        // Check if registration fee is already paid
        $regFeePaid = Transaction::where('user_id', $user->uuid)
            ->where('status', 'Success')
            ->where('payment_type', 'Registration')
            ->exists();

        if ($regFeePaid) {
            return redirect('/dashboard')->with('info', 'Registration fee has already been paid');
        }

        $data['now'] = Carbon::now();
        $data['user'] = $user;
        $data['member_loan'] = MemberLoan::where('user_id', $user->id)->where('approval_status', 1)->get();
        $data['transactions'] = Transaction::where('user_id', $user->id)->orWhere('email', $user->email)->where('status', 'Success')->latest()->paginate(10);
        $data['company'] = $company;

        return view('cooperative.member.registration-fee', $data);
    }

    public function transactions()
    {
        $data['user'] = $user =  Auth::user();
        $data['transactions'] = Transaction::where('user_id',  $user->id)->orWhere('email', $user->email)->where('status', 'Success')->latest()->paginate(10);
        if ($user->company->type == 2) {
            return view('ajo.member.transactions', $data);
        }
        return view('cooperative.member.transactions', $data);
    }



    public function oldoldmanualPayment()
    {
        $startDate = Carbon::parse(Auth::user()->created_at);
        $endDate = Carbon::now();
        $mode = Auth::user()->plan()->mode;
        $data['user'] = $user = Auth::user();
        $data['transactions'] = Transaction::where('user_id', $user->uuid)
            ->orWhere('email', $user->email)
            ->where('status', 'Success')
            ->latest()
            ->paginate(10);

        switch ($mode) {
            case 'Anytime':
                return view('cooperative.member.payment.anytime', $data);

            case 'Monthly':
                $currentDate = $startDate->copy()->startOfMonth();
                $monthsToView = [];

                while ($currentDate->lte($endDate)) {
                    $monthFormat = $currentDate->format('F Y');

                    // Check if payment exists for this month
                    $paymentExists = Transaction::where('user_id', $user->uuid)
                        ->where('status', 'Success')
                        ->where('payment_type', 'Monthly Dues')
                        ->where('month', $monthFormat)
                        ->exists();

                    $monthsToView[] = [
                        'source' => '1',
                        'month' => $monthFormat,
                        'amount' => $user->plan()->dues,
                        'paid' => $paymentExists
                    ];

                    $currentDate->addMonth();
                }

                // Check for loan repayments
                $ongoingLoan = MemberLoan::where([
                    ['user_id', $user->id],
                    ['status', 'Ongoing']
                ])->first();

                if ($ongoingLoan) {
                    $loanDate = Carbon::parse($ongoingLoan->disbursed_date);
                    $payback = $user->plan()->loan_month_repayment - 1;
                    $endMonth = Carbon::parse($ongoingLoan->disbursed_date)->addMonths($payback);

                    while ($loanDate->lte($endMonth)) {
                        $monthFormat = $loanDate->format('F Y');

                        // Check if loan payment exists for this month
                        $loanPaymentExists = Transaction::where('user_id', $user->uuid)
                            ->where('status', 'Success')
                            ->where('payment_type', 'Repayment')
                            ->where('uuid', $ongoingLoan->uuid)
                            ->where('month', $monthFormat)
                            ->exists();

                        if ($loanDate->lte(now())) {
                            $monthsToView[] = [
                                'source' => '2',
                                'month' => $monthFormat,
                                'amount' => $ongoingLoan->monthly_return,
                                'uuid' => $ongoingLoan->uuid,
                                'paid' => $loanPaymentExists
                            ];
                        }
                        $loanDate->addMonth();
                    }
                }

                $data['months'] = $monthsToView;
                $data['plan'] = $user->plan();
                return view('cooperative.member.payment.monthly', $data);

            case 'Weekly':
                $currentDate = $startDate->copy()->startOfWeek();
                $weeksToView = [];

                while ($currentDate->lte($endDate)) {
                    $weekFormat = $currentDate->format('M d') . ' - ' .
                        $currentDate->copy()->endOfWeek()->format('M d, Y');

                    // Check if payment exists for this week
                    $paymentExists = Transaction::where('user_id', $user->uuid)
                        ->where('status', 'Success')
                        ->where('payment_type', 'Weekly Dues')
                        ->where('week', $weekFormat)
                        ->exists();

                    $weeksToView[] = [
                        'source' => '1',
                        'week' => $weekFormat,
                        'amount' => $user->plan()->dues,
                        'paid' => $paymentExists
                    ];

                    $currentDate->addWeek();
                }

                // Check for loan repayments
                $ongoingLoan = MemberLoan::where([
                    ['user_id', $user->id],
                    ['status', 'Ongoing']
                ])->first();

                if ($ongoingLoan) {
                    $loanDate = Carbon::parse($ongoingLoan->disbursed_date);
                    $payback = $user->plan()->loan_month_repayment - 1;
                    $endMonth = Carbon::parse($ongoingLoan->disbursed_date)->addMonths($payback);

                    while ($loanDate->lte($endMonth)) {
                        $weekFormat = $loanDate->format('M d') . ' - ' .
                            $loanDate->copy()->endOfWeek()->format('M d, Y');

                        // Check if loan payment exists for this week
                        $loanPaymentExists = Transaction::where('user_id', $user->uuid)
                            ->where('status', 'Success')
                            ->where('payment_type', 'Repayment')
                            ->where('uuid', $ongoingLoan->uuid)
                            ->where('week', $weekFormat)
                            ->exists();

                        if ($loanDate->lte(now())) {
                            $weeksToView[] = [
                                'source' => '2',
                                'week' => $weekFormat,
                                'amount' => $ongoingLoan->monthly_return,
                                'uuid' => $ongoingLoan->uuid,
                                'paid' => $loanPaymentExists
                            ];
                        }
                        $loanDate->addWeek();
                    }
                }

                $data['months'] = $weeksToView;
                $data['plan'] = $user->plan();
                return view('cooperative.member.payment.weekly', $data);

            default:
                return redirect()->back()->with('error', 'Invalid payment mode');
        }
    }


    public function oldmanualPayment()
    {
        try {
            $user = Auth::user();
            $startDate = Carbon::parse($user->created_at);
            $endDate = Carbon::now();
            $mode = $user->plan()->mode;

            $data = [
                'user' => $user,
                'plan' => $user->plan(),
                'transactions' => Transaction::where('user_id', $user->uuid)
                    ->orWhere('email', $user->email)
                    ->where('status', 'Success')
                    ->where('payment_type', 'Cooperative-Dues')
                    ->latest()
                    ->paginate(10)
            ];

            // Get all paid transactions for faster lookup
            $paidTransactions = Transaction::where('user_id', $user->uuid)
                ->where('status', 'Success')
                ->where('payment_type', 'Cooperative-Dues')
                ->get();
            // ->groupBy(function($transaction) {
            //     return $transaction->payment_type . '_' . ($transaction->month ?? $transaction->week);
            // });

            switch ($mode) {
                case 'Anytime':
                    return view('cooperative.member.payment.anytime', $data);

                case 'Monthly':
                    $monthsToView = [];
                    $currentDate = $startDate->copy()->startOfMonth();

                    while ($currentDate->lte($endDate)) {
                        $monthFormat = $currentDate->format('F Y');

                        // Check payment status using the lookup array
                        $paymentExists = isset($paidTransactions['Monthly Dues_' . $monthFormat]);

                        $monthsToView[] = [
                            'source' => '1',
                            'month' => $monthFormat,
                            'amount' => $user->plan()->dues,
                            'paid' => $paymentExists,
                            'period' => $monthFormat
                        ];

                        $currentDate->addMonth();
                    }

                    // Handle loan repayments
                    $ongoingLoan = MemberLoan::where([
                        ['user_id', $user->id],
                        ['status', 'Ongoing']
                    ])->first();

                    if ($ongoingLoan) {
                        $loanDate = Carbon::parse($ongoingLoan->disbursed_date);
                        $payback = $user->plan()->loan_month_repayment - 1;
                        $endMonth = Carbon::parse($ongoingLoan->disbursed_date)->addMonths($payback);

                        while ($loanDate->lte($endMonth)) {
                            $monthFormat = $loanDate->format('F Y');

                            // Check loan payment status using the lookup array
                            $loanPaymentExists = isset($paidTransactions['Repayment_' . $monthFormat]);

                            if ($loanDate->lte(now())) {
                                $monthsToView[] = [
                                    'source' => '2',
                                    'month' => $monthFormat,
                                    'amount' => $ongoingLoan->monthly_return,
                                    'uuid' => $ongoingLoan->uuid,
                                    'paid' => $loanPaymentExists,
                                    'period' => $monthFormat
                                ];
                            }
                            $loanDate->addMonth();
                        }
                    }

                    $data['months'] = $monthsToView;
                    return view('cooperative.member.payment.monthly', $data);

                case 'Weekly':
                    $weeksToView = [];
                    $currentDate = $startDate->copy()->startOfWeek();

                    while ($currentDate->lte($endDate)) {
                        $weekFormat = $currentDate->format('M d') . ' - ' .
                            $currentDate->copy()->endOfWeek()->format('M d, Y');

                        // Check payment status using the lookup array
                        $paymentExists = isset($paidTransactions['Weekly Dues_' . $weekFormat]);

                        $weeksToView[] = [
                            'source' => '1',
                            'week' => $weekFormat,
                            'amount' => $user->plan()->dues,
                            'paid' => $paymentExists,
                            'period' => $weekFormat
                        ];

                        $currentDate->addWeek();
                    }

                    // Handle loan repayments for weekly mode
                    $ongoingLoan = MemberLoan::where([
                        ['user_id', $user->id],
                        ['status', 'Ongoing']
                    ])->first();

                    if ($ongoingLoan) {
                        $loanDate = Carbon::parse($ongoingLoan->disbursed_date);
                        $payback = $user->plan()->loan_month_repayment - 1;
                        $endMonth = Carbon::parse($ongoingLoan->disbursed_date)->addMonths($payback);

                        while ($loanDate->lte($endMonth)) {
                            $weekFormat = $loanDate->format('M d') . ' - ' .
                                $loanDate->copy()->endOfWeek()->format('M d, Y');

                            // Check loan payment status using the lookup array
                            $loanPaymentExists = isset($paidTransactions['Repayment_' . $weekFormat]);

                            if ($loanDate->lte(now())) {
                                $weeksToView[] = [
                                    'source' => '2',
                                    'week' => $weekFormat,
                                    'amount' => $ongoingLoan->monthly_return,
                                    'uuid' => $ongoingLoan->uuid,
                                    'paid' => $loanPaymentExists,
                                    'period' => $weekFormat
                                ];
                            }
                            $loanDate->addWeek();
                        }
                    }

                    $data['months'] = $weeksToView;
                    return view('cooperative.member.payment.weekly', $data);

                default:
                    return redirect()->back()->with('error', 'Invalid payment mode');
            }
        } catch (\Exception $e) {
            \Log::error('Manual payment error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing your request.');
        }
    }

    public function manualPayment()
    {
        try {
            $user = Auth::user();
            $startDate = Carbon::parse($user->created_at);
            $endDate = Carbon::now();
            $mode = $user->plan()->mode;


            $data = [
                'user' => $user,
                'plan' => $user->plan()
            ];

            // Get all paid cooperative dues for faster lookup
            $paidDues = Transaction::where('user_id', $user->uuid)
                ->where('status', 'Success')
                ->where('payment_type', 'Cooperative-Dues')
                ->get()
                ->mapWithKeys(function ($transaction) {
                    $key = $transaction->month ?? $transaction->week;
                    return [$key => true];
                })
                ->toArray();


            switch ($mode) {
                case 'Anytime':
                    return view('cooperative.member.payment.anytime', $data);

                case 'Monthly':
                    $monthsToView = [];
                    $currentDate = $startDate->copy()->startOfMonth();

                    while ($currentDate->lte($endDate)) {
                        $monthFormat = $currentDate->format('F Y');

                        // Check if this month is paid
                        $paymentExists = isset($paidDues[$monthFormat]);

                        $monthsToView[] = [
                            'source' => '1',
                            'month' => $monthFormat,
                            'amount' => $user->plan()->dues,
                            'paid' => $paymentExists,
                            'period' => $monthFormat,
                            'payment_type' => 'Cooperative-Dues'
                        ];

                        $currentDate->addMonth();
                    }

                    // Handle loan repayments
                    $ongoingLoan = MemberLoan::where([
                        ['user_id', $user->id],
                        ['status', 'Ongoing']
                    ])->first();

                    if ($ongoingLoan) {
                        $loanPayments = Transaction::where('user_id', $user->uuid)
                            ->where('status', 'Success')
                            ->where('payment_type', 'Repayment')
                            ->where('uuid', $ongoingLoan->uuid)
                            ->pluck('month')
                            ->flip()
                            ->toArray();

                        $loanDate = Carbon::parse($ongoingLoan->disbursed_date);
                        $payback = $user->plan()->loan_month_repayment - 1;
                        $endMonth = Carbon::parse($ongoingLoan->disbursed_date)->addMonths($payback);

                        while ($loanDate->lte($endMonth)) {
                            $monthFormat = $loanDate->format('F Y');

                            if ($loanDate->lte(now())) {
                                $monthsToView[] = [
                                    'source' => '2',
                                    'month' => $monthFormat,
                                    'amount' => $ongoingLoan->monthly_return,
                                    'uuid' => $ongoingLoan->uuid,
                                    'paid' => isset($loanPayments[$monthFormat]),
                                    'period' => $monthFormat,
                                    'payment_type' => 'Repayment'
                                ];
                            }
                            $loanDate->addMonth();
                        }
                    }

                    $data['months'] = $monthsToView;
                    return view('cooperative.member.payment.monthly', $data);

                case 'Weekly':
                    $weeksToView = [];
                    $currentDate = $startDate->copy()->startOfWeek();

                    while ($currentDate->lte($endDate)) {
                        $weekFormat = $currentDate->format('M d') . ' - ' .
                            $currentDate->copy()->endOfWeek()->format('M d, Y');

                        // Check if this week is paid
                        $paymentExists = isset($paidDues[$weekFormat]);

                        $weeksToView[] = [
                            'source' => '1',
                            'week' => $weekFormat,
                            'amount' => $user->plan()->dues,
                            'paid' => $paymentExists,
                            'period' => $weekFormat,
                            'payment_type' => 'Cooperative-Dues'
                        ];

                        $currentDate->addWeek();
                    }

                    // Handle loan repayments
                    $ongoingLoan = MemberLoan::where([
                        ['user_id', $user->id],
                        ['status', 'Ongoing']
                    ])->first();

                    if ($ongoingLoan) {
                        $loanPayments = Transaction::where('user_id', $user->uuid)
                            ->where('status', 'Success')
                            ->where('payment_type', 'Repayment')
                            ->where('uuid', $ongoingLoan->uuid)
                            ->pluck('week')
                            ->flip()
                            ->toArray();

                        $loanDate = Carbon::parse($ongoingLoan->disbursed_date);
                        $payback = $user->plan()->loan_month_repayment - 1;
                        $endMonth = Carbon::parse($ongoingLoan->disbursed_date)->addMonths($payback);

                        while ($loanDate->lte($endMonth)) {
                            $weekFormat = $loanDate->format('M d') . ' - ' .
                                $loanDate->copy()->endOfWeek()->format('M d, Y');

                            if ($loanDate->lte(now())) {
                                $weeksToView[] = [
                                    'source' => '2',
                                    'week' => $weekFormat,
                                    'amount' => $ongoingLoan->monthly_return,
                                    'uuid' => $ongoingLoan->uuid,
                                    'paid' => isset($loanPayments[$weekFormat]),
                                    'period' => $weekFormat,
                                    'payment_type' => 'Repayment'
                                ];
                            }
                            $loanDate->addWeek();
                        }
                    }

                    $data['months'] = $weeksToView;
                    return view('cooperative.member.payment.weekly', $data);

                default:
                    return redirect()->back()->with('error', 'Invalid payment mode');
            }
        } catch (\Exception $e) {
            \Log::error('Manual payment error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing your request.');
        }
    }

    public function oldcontributionPayment()
    {
        $data['user'] = $user = Auth::user();
        $groups = GroupMember::where('user_id', Auth::user()->id)
            ->select('group_id')
            ->distinct()
            ->pluck('group_id')
            ->toArray();

        $participation = Group::whereIn('id', $groups)->where('status', 1)->get();
        $allMonths = [];

        foreach ($participation as $single) {
            $startDate = Carbon::parse($single->start_date);
            $endDate = Carbon::now();
            $mode = $single->mode;

            if ($mode == "Weekly") {
                $currentDate = $startDate->copy()->startOfWeek();
                $weeksToView = [];

                while ($currentDate->lte($endDate)) {
                    $weekStart = $currentDate->format('M d');
                    $weekEnd = $currentDate->copy()->endOfWeek()->format('M d, Y');
                    $weeksToView[] = "$weekStart - $weekEnd";
                    $currentDate->addWeek();
                }


                $myWeeks = Transaction::where('user_id', auth()->user()->uuid)
                    ->where([
                        ['status', 'Success'],
                        ['payment_type', 'Contribution'],
                        ['uuid', $single->uuid]
                    ])
                    ->pluck('week')  // Changed from 'month' to 'week'
                    ->toArray();

                foreach ($weeksToView as $thisWeek) {
                    $check = in_array($thisWeek, $myWeeks);
                    if (!$check) {
                        $allMonths[] = [
                            'source' => '1',
                            'week' => $thisWeek,
                            'period' => $thisWeek,  // Added period for consistency
                            'amount' => $single->amount,
                            'uuid' => $single->uuid,
                            'title' => $single->title,
                            'mode' => $mode,
                            'paid' => $isPaid
                        ];
                    }
                }
            } elseif ($mode == "Monthly") {
                $monthsToView = [];
                $currentDate = $startDate->copy()->startOfMonth();

                while ($currentDate->lte($endDate)) {
                    $monthsToView[] = $currentDate->format('F Y');
                    $currentDate->addMonth();
                }

                $myMonths = Transaction::where('user_id', auth()->user()->uuid)
                    ->where([
                        ['status', 'Success'],
                        ['payment_type', 'Contribution'],
                        ['uuid', $single->uuid]
                    ])
                    ->pluck('month')
                    ->toArray();

                foreach ($monthsToView as $thisMonth) {
                    $check = in_array($thisMonth, $myMonths);
                    if (!$check) {
                        $allMonths[] = [
                            'source' => '1',
                            'month' => $thisMonth,
                            'period' => $thisMonth,  // Added period for consistency
                            'amount' => $single->amount,
                            'uuid' => $single->uuid,
                            'title' => $single->title,
                            'mode' => $mode
                        ];
                    }
                }
            } else { // Daily
                $daysToView = [];
                $currentDate = $startDate->copy()->startOfDay();

                while ($currentDate->lte($endDate)) {
                    $daysToView[] = $currentDate->format('F d, Y');
                    $currentDate->addDay();
                }

                $myDays = Transaction::where('user_id', auth()->user()->uuid)
                    ->where([
                        ['status', 'Success'],
                        ['payment_type', 'Contribution'],
                        ['uuid', $single->uuid]
                    ])
                    ->pluck('month')  // Consider creating a 'day' column in transactions
                    ->toArray();

                foreach ($daysToView as $thisDay) {
                    $check = in_array($thisDay, $myDays);
                    if (!$check) {
                        $allMonths[] = [
                            'source' => '1',
                            'month' => $thisDay,
                            'period' => $thisDay,  // Added period for consistency
                            'amount' => $single->amount,
                            'uuid' => $single->uuid,
                            'title' => $single->title,
                            'mode' => $mode
                        ];
                    }
                }
            }
        }

        return view($user->company->type == 2 ? 'ajo.member.contribution' : 'cooperative.member.payment.contribution', [
            'months' => $allMonths,
            'user' => Auth::user()
        ]);
    }

    public function contributionPayment()
    {
        try {
            $user = Auth::user();
            if (!$user) {

                return redirect()->route('login');
            }

            $data['user'] = $user;

            // Fetch groups the user is part of
            $groupIds = GroupMember::where('user_id', $user->id)
                ->distinct()
                ->pluck('group_id')
                ->toArray();

            $participation = Group::whereIn('id', $groupIds)
                ->where('status', 1)
                ->get();



            // Fetch all relevant transactions
            // Fetch all paid contributions
            $transactions = Transaction::where('user_id', $user->uuid)
                ->where('status', 'Success')
                ->where('payment_type', 'Contribution')
                ->whereIn('uuid', $participation->pluck('uuid'))
                ->select('uuid', 'week', 'month')
                ->get();

            // Create a lookup array for faster checking
            $paidContributions = [];
            foreach ($transactions as $transaction) {
                $key = $transaction->uuid . '_' . ($transaction->week ?? $transaction->month);
                $paidContributions[$key] = true;
            }

            $allMonths = [];

            foreach ($participation as $single) {
                $startDate = Carbon::parse($single->start_date);
                $endDate = Carbon::now();
                $mode = $single->mode;

                if ($mode == "Weekly") {
                    $currentDate = $startDate->copy()->startOfWeek();
                    while ($currentDate->lte($endDate)) {
                        $weekStart = $currentDate->format('M d');
                        $weekEnd = $currentDate->copy()->endOfWeek()->format('M d, Y');
                        $weekFormat = "$weekStart - $weekEnd";

                        // Check if this specific contribution is paid
                        $isPaid = isset($paidContributions[$single->uuid . '_' . $weekFormat]);

                        $allMonths[] = [
                            'week' => $weekFormat,
                            'period' => $weekFormat,
                            'amount' => $single->amount,
                            'uuid' => $single->uuid,
                            'title' => $single->title,
                            'mode' => $mode,
                            'paid' => $isPaid
                        ];

                        $currentDate->addWeek();
                    }
                } elseif ($mode == "Monthly") {
                    $currentDate = $startDate->copy()->startOfMonth();
                    while ($currentDate->lte($endDate)) {
                        $monthFormat = $currentDate->format('F Y');

                        $isPaid = isset($transactions[$single->uuid]) &&
                            $transactions[$single->uuid]->contains('month', $monthFormat);

                        $allMonths[] = [
                            'month' => $monthFormat,
                            'period' => $monthFormat,
                            'amount' => $single->amount,
                            'uuid' => $single->uuid,
                            'title' => $single->title,
                            'mode' => $mode,
                            'paid' => $isPaid
                        ];

                        $currentDate->addMonth();
                    }
                } else { // Daily
                    $currentDate = $startDate->copy()->startOfDay();
                    while ($currentDate->lte($endDate)) {
                        $dayFormat = $currentDate->format('F d, Y');

                        // Check if this specific day contribution is paid
                        $isPaid = isset($paidContributions[$single->uuid . '_' . $dayFormat]);

                        $allMonths[] = [
                            'day' => $dayFormat,
                            'period' => $dayFormat,
                            'amount' => $single->amount,
                            'uuid' => $single->uuid,
                            'title' => $single->title,
                            'mode' => $mode,
                            'paid' => $isPaid
                        ];

                        $currentDate->addDay();
                    }
                }
            }

            // Log for debugging


            $data['months'] = $allMonths;

            // Render view based on company type
            $view = $user->company->type == 2 ? 'ajo.member.contribution' : 'cooperative.member.payment.contribution';
            return view($view, $data);
        } catch (\Exception $e) {
            Log::error('Failed to load contribution payment', [
                'error' => $e->getMessage(),
                'user_id' => $user->id ?? 'unknown'
            ]);
            return redirect()->back()->with('error', 'An error occurred while loading contributions.');
        }
    }
    public function newcontributionPayment()
    {
        $data['user'] = $user = Auth::user();
        $groups = GroupMember::where('user_id', Auth::user()->id)
            ->select('group_id')
            ->distinct()
            ->pluck('group_id')
            ->toArray();

        $participation = Group::whereIn('id', $groups)->where('status', 1)->get();
        $allMonths = [];

        foreach ($participation as $single) {
            $startDate = Carbon::parse($single->start_date);
            $endDate = Carbon::now();
            $mode = $single->mode;

            if ($mode == "Weekly") {
                $currentDate = $startDate->copy()->startOfWeek();
                $weeksToView = [];

                while ($currentDate->lte($endDate)) {
                    $weekStart = $currentDate->format('M d');
                    $weekEnd = $currentDate->copy()->endOfWeek()->format('M d, Y');
                    $weekFormat = "$weekStart - $weekEnd";

                    // Check if this specific week for this contribution is paid
                    $isPaid = Transaction::where('user_id', auth()->user()->id)
                        ->where([
                            ['status', 'Success'],
                            ['payment_type', 'Contribution'],
                            ['uuid', $single->uuid],
                            ['week', $weekFormat]
                        ])
                        ->exists();

                    $allMonths[] = [
                        'source' => '1',
                        'week' => $weekFormat,
                        'period' => $weekFormat,
                        'amount' => $single->amount,
                        'uuid' => $single->uuid,
                        'title' => $single->title,
                        'mode' => $mode,
                        'paid' => $isPaid
                    ];

                    $currentDate->addWeek();
                }
            } elseif ($mode == "Monthly") {
                $currentDate = $startDate->copy()->startOfMonth();

                while ($currentDate->lte($endDate)) {
                    $monthFormat = $currentDate->format('F Y');

                    // Check if this specific month for this contribution is paid
                    $isPaid = Transaction::where('user_id', auth()->user()->id)
                        ->where([
                            ['status', 'Success'],
                            ['payment_type', 'Contribution'],
                            ['uuid', $single->uuid],
                            ['month', $monthFormat]
                        ])
                        ->exists();

                    $allMonths[] = [
                        'source' => '1',
                        'month' => $monthFormat,
                        'period' => $monthFormat,
                        'amount' => $single->amount,
                        'uuid' => $single->uuid,
                        'title' => $single->title,
                        'mode' => $mode,
                        'paid' => $isPaid
                    ];

                    $currentDate->addMonth();
                }
            } else { // Daily
                $currentDate = $startDate->copy()->startOfDay();

                while ($currentDate->lte($endDate)) {
                    $dayFormat = $currentDate->format('F d, Y');

                    // Check if this specific day for this contribution is paid
                    $isPaid = Transaction::where('user_id', auth()->user()->id)
                        ->where([
                            ['status', 'Success'],
                            ['payment_type', 'Contribution'],
                            ['uuid', $single->uuid],
                            ['month', $dayFormat] // Using month column for daily payments
                        ])
                        ->exists();

                    $allMonths[] = [
                        'source' => '1',
                        'month' => $dayFormat,
                        'period' => $dayFormat,
                        'amount' => $single->amount,
                        'uuid' => $single->uuid,
                        'title' => $single->title,
                        'mode' => $mode,
                        'paid' => $isPaid
                    ];

                    $currentDate->addDay();
                }
            }
        }

        $data['months'] = $allMonths;
        return view('cooperative.member.payment.contribution', $data);
    }

    public function loanPayment()
    {
        $startDate = Carbon::parse(Auth::user()->created_at);
        $endDate = Carbon::now();
        $mode = Auth::user()->plan()->mode;
        //dd($mode);

        $data['plan'] = Auth::user()->plan();
        // // check if member has ongoing loan application
        $check = MemberLoan::where([['user_id', auth()->user()->id], ['status', 'Ongoing']])->first();
        $dateArray = [];
        if ($check) {
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
            $checkPayment = Transaction::where('user_id',  auth()->user()->id)->where([['status', 'Success'], ['payment_type', 'Repayment'], ['uuid', $check->uuid]])->pluck('month')->toArray();
            // $dateArray = [];
            // dd($availableNow);
            foreach ($availableNow as $pay) {
                $spue =  in_array($pay, $checkPayment);
                $now = now()->format('F Y');
                // dd($now,$pay);
                if ($spue == false && \DateTime::createFromFormat('F Y', $pay) <= \DateTime::createFromFormat('F Y', $now)) {
                    $dateArray[] = ['source' => '2', 'month' => $pay, 'amount' => $check->monthly_return, 'uuid' => $check->uuid];
                }
            }
        }
        // dd($dateArray);
        $data['months'] =  $dateArray;
        $data['user'] = Auth::user();
        // $data['months'] = $months + $dateArray;
        // dd($check, $data);
        return view('cooperative.member.payment.pending', $data);
    }

    public function automaticPayment() {}
}
