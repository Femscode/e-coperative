<?php

namespace App\Http\Livewire;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;

class PendingContributionDues extends Component
{
    public $memberId;
    public function mount($memberId)
    {
        $this->memberId = $memberId;
    }
    public function oldrender()
    {
        $group = Group::where('uuid', $this->memberId)->first();
        $members = GroupMember::where('group_id', $group->id)->get();
        $startDate = Carbon::parse($group->start_date);
        $endDate = Carbon::now();
        // dd($startDate);
        $mode = $group->mode;
        // dd($members);
        $months = [];
        foreach($members as $single){
            
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
                $myWeeks = Transaction::where('user_id', $single->user_id)
                    ->where([
                        ['status', 'Success'],
                        ['payment_type', 'Contribution']
                    ])
                    ->pluck('week')  // Change 'month' to 'week' if you have a week field
                    ->toArray();
        
                // $weeks = [];
                // dd()
                foreach ($weeksToView as $thisWeek) {
                    $check = in_array($thisWeek, $myWeeks);
                    if (!$check) {
                        $months[] = ['name' => $single->user->name, 'month' => $thisWeek, "amount" => $group->amount, 'uuid' => $group->uuid];
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
                $myMonths = Transaction::where('user_id',  $single->user_id)->where([['status', 'Success'],['payment_type','Contribution']])->pluck('month')->toArray();
                // dd($monthsToView, $myMonths);
                // $months = [];
                foreach ($monthsToView as $thisMonth) {
                    $check =  in_array($thisMonth, $myMonths);
                    if ($check == false) {
                        $months[] = ['name' => $single->user->name, 'month' => $thisMonth, "amount" => $group->amount, 'uuid' => $group->uuid];
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
                $myMonths = Transaction::where('user_id',  $single->user_id)->where([['status', 'Success'],['payment_type','Contribution']])->pluck('day')->toArray();
                // dd($monthsToView, $myMonths);
                // $months = [];
                foreach ($monthsToView as $thisMonth) {
                    $check =  in_array($thisMonth, $myMonths);
                    if ($check == false) {
                        $months[] = ['name' => $single->user->name, 'month' => $thisMonth, "amount" => $group->amount, 'uuid' => $group->uuid];
                    }
                }
            }
            // dd($months);
        }
        $data = [
            'title' => "Dues Payment On $group->title Circle",
           'months' => $months,
        ];
        // dd($data);
        return view('livewire.pending-contribution-dues', $data);
    }


    public function render()
    {
        $group = Group::where('uuid', $this->memberId)->first();
        $members = GroupMember::where('group_id', $group->id)->get();
        $startDate = Carbon::parse($group->start_date);
        $endDate = Carbon::now();
        $mode = $group->mode;
        $months = [];
        
        foreach($members as $single){
            if($mode == "Weekly"){
                $currentDate = $startDate->copy()->startOfWeek();
                $weeksToView = [];
        
                while ($currentDate->lte($endDate)) {
                    $weekStart = $currentDate->format('M d');
                    $weekEnd = $currentDate->copy()->endOfWeek()->format('M d, Y');
                    $weeksToView[] = "$weekStart - $weekEnd";
                    $currentDate->addWeek();
                }

                $myWeeks = Transaction::where([
                    ['user_id', $single->user_id],
                    ['status', 'Success'],
                    ['payment_type', 'Contribution'],
                    ['uuid', $group->uuid] // Add this line to filter by specific contribution
                ])->pluck('week')->toArray();
        
                foreach ($weeksToView as $thisWeek) {
                    $check = in_array($thisWeek, $myWeeks);
                    if (!$check) {
                        $months[] = ['name' => $single->user->name, 'month' => $thisWeek, "amount" => $group->amount, 'uuid' => $group->uuid];
                    }
                }
            }elseif ($mode == "Monthly") {
                $monthsToView = [];
                $currentDate = $startDate->copy()->startOfMonth();
                
                while ($currentDate->lte($endDate)) {
                    $monthsToView[] = $currentDate->format('F Y');
                    $currentDate->addMonth();
                }
                
                $myMonths = Transaction::where([
                    ['user_id', $single->user_id],
                    ['status', 'Success'],
                    ['payment_type', 'Contribution'],
                    ['uuid', $group->uuid] // Add this line to filter by specific contribution
                ])->pluck('month')->toArray();
                
                foreach ($monthsToView as $thisMonth) {
                    $check = in_array($thisMonth, $myMonths);
                    if (!$check) {
                        $months[] = ['name' => $single->user->name, 'month' => $thisMonth, "amount" => $group->amount, 'uuid' => $group->uuid];
                    }
                }
            }else{
                $monthsToView = [];
                $currentDate = $startDate->copy()->startOfDay();
                
                while ($currentDate->lte($endDate)) {
                    $monthsToView[] = $currentDate->format('F d, Y');
                    $currentDate->addDay();
                }
                
                $myMonths = Transaction::where([
                    ['user_id', $single->user_id],
                    ['status', 'Success'],
                    ['payment_type', 'Contribution'],
                    ['uuid', $group->uuid] // Add this line to filter by specific contribution
                ])->pluck('day')->toArray();
                
                foreach ($monthsToView as $thisMonth) {
                    $check = in_array($thisMonth, $myMonths);
                    if (!$check) {
                        $months[] = ['name' => $single->user->name, 'month' => $thisMonth, "amount" => $group->amount, 'uuid' => $group->uuid];
                    }
                }
            }
        }
        
        $data = [
            'title' => "Dues Payment On $group->title Circle",
            'months' => $months,
        ];
        
        return view('livewire.pending-contribution-dues', $data);
    }
}
