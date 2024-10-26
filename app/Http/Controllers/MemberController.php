<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\MemberLoan;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class MemberController extends Controller
{
    public function index(Request $request){
        $date = date('Y-m-d', strtotime(Auth::user()->created_at));
        $data['now'] = Carbon::now();
        // $data['activities'] = Activity::where('is_global', '=', 1)
        // ->where('created_at', '>=', $date)
        // ->orwhere(
        //     function($query) {
        //       return $query
        //              ->where('user_id', Auth::user()->id);
        //      })
        //      ->get();
        $data['transactions'] = Transaction::where('user_id',  auth()->user()->id)->orWhere('email', auth()->user()->email)->where('status', 'Success')->get();
        return view('member.index', $data);
    }

    public function manualPayment(){
        $startDate = Carbon::parse(Auth::user()->created_at);
        $endDate = Carbon::now();
        $mode = Auth::user()->plan()->mode;
        //dd($mode);
        switch($mode){
            case 'Anytime':

                return view ('member.payment.anytime');
                break;

            case 'Monthly':

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
                // $data['months'] = $months + $dateArray;
                // dd($check, $data);
                return view ('member.payment.monthly', $data);
                break;
            case 'Weekly':

                //     $this->redirectTo = '/member';

                // return $this->redirectTo;
                break;


        }
        $currentDate = $startDate->copy()->startOfWeek();  // Start at the beginning of the week
        $weeksToView = [];

        while ($currentDate->lte($endDate)) {
            $weekStart = $currentDate->format('M d');
            $weekEnd = $currentDate->copy()->endOfWeek()->format('M d, Y');
            $weeksToView[] = "$weekStart - $weekEnd";
            $currentDate->addWeek();  // Move to the next week
        }
        // dd("here");
        // Assuming your `Transaction` records store weeks in a similar format as above (or adjust the format as needed)
        $myWeeks = Transaction::where('user_id', auth()->user()->id)
            ->where([
                ['status', 'Success'],
                ['payment_type', 'Weekly Dues']
            ])
            ->pluck('week')  // Change 'month' to 'week' if you have a week field
            ->toArray();

        $weeks = [];
        foreach ($weeksToView as $thisWeek) {
            $check = in_array($thisWeek, $myWeeks);
            if (!$check) {
                $weeks[] = ['source' => '1', 'week' => $thisWeek];
            }
        }
        // dd("here");
        // $currentDate = $startDate->copy()->startOfMonth();
        // while ($currentDate->lte($endDate) && $currentDate->month <= $endDate->month) {
        //     $monthsToView[] = $currentDate->format('F Y');
        //     $currentDate->addMonth();
        // }
        // // dd($monthsToView);
        // $myMonths = Transaction::where('user_id',  auth()->user()->id)->where([['status', 'Success'],['payment_type','Monthly Dues']])->pluck('month')->toArray();
        // // dd($monthsToView, $myMonths);
        // $months = [];
        // foreach ($monthsToView as $thisMonth) {
        //     $check =  in_array($thisMonth, $myMonths);
        //     if ($check == false) {
        //         $months[] = ['source' => '1', 'month' => $thisMonth];
        //     }
        // }
        // $data['months'] = $months ;
        $data['plan'] = Auth::user()->plan();
        // // check if member has ongoing loan application
        // $check = MemberLoan::where([['user_id', auth()->user()->id],['status', 'Ongoing']])->first();
        // $dateArray = [];
        // if($check){
        //     $payback = $data['plan']->loan_month_repayment - 1;
        //     $loanDate = Carbon::parse($check->disbursed_date);
        //     // dd($loanDate);
        //     $endMonth = Carbon::parse($check->disbursed_date)->addMonths($payback);
        //     // Loop through the months between start date and current date
        //     while ($loanDate->lessThanOrEqualTo($endMonth)) {
        //         $availableNow[] = $loanDate->format('F Y');
        //         $loanDate->addMonth();
        //     }
        //     //check if any payment has been made for this loan
        //     $checkPayment = Transaction::where('user_id',  auth()->user()->id)->where([['status', 'Success'],['payment_type','Repayment'],['uuid', $check->uuid]])->pluck('month')->toArray();
        //     // $dateArray = [];
        //     // dd($availableNow);
        //     foreach ($availableNow as $pay) {
        //         $spue =  in_array($pay, $checkPayment);
        //         $now = now()->format('F Y');
        //         // dd($now,$pay);
        //         if ($spue == false && \DateTime::createFromFormat('F Y', $pay) <= \DateTime::createFromFormat('F Y', $now)) {
        //             $dateArray[] = ['source' => '2', 'month' => $pay, 'amount' => $check->monthly_return, 'uuid' => $check->uuid] ;
        //         }
        //     }
        // }
        // dd($dateArray);
        $data['months'] = $weeks;//array_merge($months, $dateArray);
        // $data['months'] = $months + $dateArray;
        // dd($check, $data);
        return view ('member.payment.weekly', $data);
    }

    public function automaticPayment(){

    }
}
