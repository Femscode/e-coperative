<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Group;
use Carbon\CarbonPeriod;
use App\Models\MemberLoan;
use App\Models\GroupMember;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $data['user'] = $user = Auth::user();
        $data['member_loan'] = MemberLoan::where('user_id',$user->id)->where('approval_status',1)->get();
        $data['transactions'] = Transaction::where('user_id', $user->id)->orWhere('email',$user->email)->where('status', 'Success')->latest()->paginate(10);
        return view('cooperative.member.index', $data);
      
    }

    public function transactions() {
        $data['user'] = $user =  Auth::user();
        $data['transactions'] = Transaction::where('user_id',  $user->id)->orWhere('email', $user->email)->where('status', 'Success')->latest()->paginate(10);
        return view('cooperative.member.transactions', $data);
       
    }

    public function manualPayment(){
        $startDate = Carbon::parse(Auth::user()->created_at);
        $endDate = Carbon::now();
        $mode = Auth::user()->plan()->mode;
        $data['user'] = $user =  Auth::user();
        $data['transactions'] = Transaction::where('user_id',  $user->id)->orWhere('email', $user->email)->where('status', 'Success')->latest()->paginate(10);
        
        //dd($mode);
        switch($mode){
            case 'Anytime':
               
                return view ('cooperative.member.payment.anytime',$data);
                return view ('member.payment.anytime',$data);
                break;

            case 'Monthly':

                $currentDate = $startDate->copy()->startOfMonth();
                while ($currentDate->lte($endDate) && ($currentDate->year < $endDate->year || ($currentDate->year == $endDate->year && $currentDate->month <= $endDate->month))) {
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
                return view ('cooperative.member.payment.monthly', $data);
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
        // dd()
        foreach ($weeksToView as $thisWeek) {
            $check = in_array($thisWeek, $myWeeks);
            if (!$check) {
                $weeks[] = ['source' => '1', 'week' => $thisWeek];
            }
        }

        $data['plan'] = Auth::user()->plan();
        
        $data['months'] = $weeks;//array_merge($months, $dateArray);
        $data['user'] = Auth::user();
        // $data['months'] = $months + $dateArray;
        // dd($check, $data);
        return view ('cooperative.member.payment.weekly', $data);
        return view ('member.payment.weekly', $data);
    }
    public function contributionPayment(){
        $groups = GroupMember::where('user_id', Auth::user()->id)->select('group_id')->distinct()->pluck('group_id')->toArray();
        $participation = Group::whereIn('id', $groups)->where('status', 1)->get();
        $months = [];
        foreach($participation as $single){
            $startDate = Carbon::parse($single->start_date);
            $endDate = Carbon::now();
            // dd($startDate);
            $mode = $single->mode;
            if($mode == "Weekly"){
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
                        ['payment_type', 'Contribution']
                    ])
                    ->pluck('month')  // Change 'month' to 'week' if you have a week field
                    ->toArray();
        
                $months = [];
                // dd('here');
                foreach ($weeksToView as $thisWeek) {
                    $check = in_array($thisWeek, $myWeeks);
                    if (!$check) {
                        $months[] = ['source' => '1', 'month' => $thisWeek, "amount" => $single->amount, 'uuid' => $single->uuid];
                    }
                }
            }elseif ($mode == "Monthly") {
                $monthsToView = [];
                $currentDate = $startDate->copy()->startOfMonth();
                // dd($currentDate);
                while ($currentDate->lte($endDate) && ($currentDate->year < $endDate->year || ($currentDate->year == $endDate->year && $currentDate->month <= $endDate->month))) {
                    $monthsToView[] = $currentDate->format('F Y');
                    $currentDate->addMonth();
                }
                // dd($monthsToView);
                $myMonths = Transaction::where('user_id',  auth()->user()->id)->where([['status', 'Success'],['payment_type','Contribution']])->pluck('month')->toArray();
                // dd($monthsToView, $myMonths);
                $months = [];
                foreach ($monthsToView as $thisMonth) {
                    $check =  in_array($thisMonth, $myMonths);
                    if ($check == false) {
                        $months[] = ['source' => '1', 'month' => $thisMonth, "amount" => $single->amount, 'uuid' => $single->uuid];
                    }
                }
            }else{
                $monthsToView = [];
                $currentDate = $startDate->copy()->startOfDay();
                // dd($currentDate);
                while ($currentDate->lte($endDate) && ($currentDate->year < $endDate->year || ($currentDate->year == $endDate->year && $currentDate->month <= $endDate->month))) {
                    $monthsToView[] = $currentDate->format('F Y');
                    $currentDate->addDay();
                }
                // dd($monthsToView);
                $myMonths = Transaction::where('user_id',  auth()->user()->id)->where([['status', 'Success'],['payment_type','Contribution']])->pluck('month')->toArray();
                // dd($monthsToView, $myMonths);
                $months = [];
                foreach ($monthsToView as $thisMonth) {
                    $check =  in_array($thisMonth, $myMonths);
                    if ($check == false) {
                        $months[] = ['source' => '1', 'month' => $thisMonth, "amount" => $single->amount, 'uuid' => $single->uuid];
                    }
                }
            }

        }
        // dd($months);
        $data['months'] = $months;
        $data['user'] = Auth::user();
        return view ('cooperative.member.payment.contribution', $data);  
    }
    public function loanPayment(){
        $startDate = Carbon::parse(Auth::user()->created_at);
        $endDate = Carbon::now();
        $mode = Auth::user()->plan()->mode;
        //dd($mode);
       
        $data['plan'] = Auth::user()->plan();
        // // check if member has ongoing loan application
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
        $data['months'] =  $dateArray;
        $data['user'] = Auth::user();
        // $data['months'] = $months + $dateArray;
        // dd($check, $data);
        return view ('cooperative.member.payment.pending', $data);
       
    }

    public function automaticPayment(){

    }
}
