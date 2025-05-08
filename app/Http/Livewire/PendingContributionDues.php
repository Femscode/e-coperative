<?php

namespace App\Http\Livewire;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class PendingContributionDues extends Component
{
    public $memberId;
    public $search = '';
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
        $mode = $group->mode;
        $months = [];

        foreach ($members as $single) {
            if ($mode == "Weekly") {
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
            } elseif ($mode == "Monthly") {
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
            } else {
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



    public function newrender()
    {
        $group = Group::where('uuid', $this->memberId)->first();
        $members = GroupMember::where('group_id', $group->id)->get();
        $totalMembers = $members->count(); // Get total number of members
        $startDate = Carbon::parse($group->start_date);
        $endDate = Carbon::now();
        $mode = $group->mode;
        $months = [];

        foreach ($members as $single) {
            $contributionCount = 0; // Track contributions for this member

            if ($mode == "Weekly") {
                $currentDate = $startDate->copy()->startOfWeek();
                $weeksToView = [];

                while ($currentDate->lte($endDate) && $contributionCount < $totalMembers) {
                    $weekStart = $currentDate->format('M d');
                    $weekEnd = $currentDate->copy()->endOfWeek()->format('M d, Y');
                    $weekFormat = "$weekStart - $weekEnd";
                    $weeksToView[] = $weekFormat;
                    $currentDate->addWeek();
                }

                $myWeeks = Transaction::where([
                    ['user_id', $single->user_id],
                    ['status', 'Success'],
                    ['payment_type', 'Contribution'],
                    ['uuid', $group->uuid]
                ])->pluck('week')->toArray();

                foreach ($weeksToView as $thisWeek) {
                    if ($contributionCount >= $totalMembers) {
                        break; // Stop if contribution limit is reached
                    }
                    $check = in_array($thisWeek, $myWeeks);
                    if (!$check) {
                        $months[] = [
                            'name' => $single->user->name,
                            'month' => $thisWeek,
                            'amount' => $group->amount,
                            'uuid' => $group->uuid
                        ];
                        $contributionCount++;
                    }
                }
            } elseif ($mode == "Monthly") {
                $monthsToView = [];
                $currentDate = $startDate->copy()->startOfMonth();

                while ($currentDate->lte($endDate) && $contributionCount < $totalMembers) {
                    $monthFormat = $currentDate->format('F Y');
                    $monthsToView[] = $monthFormat;
                    $currentDate->addMonth();
                }

                $myMonths = Transaction::where([
                    ['user_id', $single->user_id],
                    ['status', 'Success'],
                    ['payment_type', 'Contribution'],
                    ['uuid', $group->uuid]
                ])->pluck('month')->toArray();

                foreach ($monthsToView as $thisMonth) {
                    if ($contributionCount >= $totalMembers) {
                        break; // Stop if contribution limit is reached
                    }
                    $check = in_array($thisMonth, $myMonths);
                    if (!$check) {
                        $months[] = [
                            'name' => $single->user->name,
                            'month' => $thisMonth,
                            'amount' => $group->amount,
                            'uuid' => $group->uuid
                        ];
                        $contributionCount++;
                    }
                }
            } else { // Daily
                $monthsToView = [];
                $currentDate = $startDate->copy()->startOfDay();

                while ($currentDate->lte($endDate) && $contributionCount < $totalMembers) {
                    $dayFormat = $currentDate->format('F d, Y');
                    $monthsToView[] = $dayFormat;
                    $currentDate->addDay();
                }

                $myDays = Transaction::where([
                    ['user_id', $single->user_id],
                    ['status', 'Success'],
                    ['payment_type', 'Contribution'],
                    ['uuid', $group->uuid]
                ])->pluck('day')->toArray();

                foreach ($monthsToView as $thisDay) {
                    if ($contributionCount >= $totalMembers) {
                        break; // Stop if contribution limit is reached
                    }
                    $check = in_array($thisDay, $myDays);
                    if (!$check) {
                        $months[] = [
                            'name' => $single->user->name,
                            'month' => $thisDay,
                            'amount' => $group->amount,
                            'uuid' => $group->uuid
                        ];
                        $contributionCount++;
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


    public function render()
    {
        $group = Group::where('uuid', $this->memberId)->first();
        $members = GroupMember::where('group_id', $group->id)->get();
        $totalMembers = $members->count(); // Get total number of members
        $startDate = Carbon::parse($group->start_date);
        $endDate = Carbon::now();
        $mode = $group->mode;
        $months = [];

        $realmembers = User::whereIn('id', $members->pluck('user_id'))->get();

    //    dd($realmembers);

        // Fetch all paid contributions for the group
        $transactions = Transaction::whereIn('user_id', $realmembers->pluck('uuid'))
            ->where('status', 'Success')
            ->where('payment_type', 'Contribution')
            ->where('uuid', $group->uuid)
            ->select('user_id', 'week', 'month', 'day')
            ->get();
            // dd($transactions);

            

        // Create a lookup array for faster checking
        $paidContributions = [];
        foreach ($transactions as $transaction) {
            $periodValue = $transaction->day ?? $transaction->week ?? $transaction->month;
            $key = $periodValue;  // FIXED: Use user_id instead of uuid
            $paidContributions[$key] = true;
          }

        foreach ($members as $single) {
            $contributionCount = 0; // Track contributions for this member

            if ($mode == "Weekly") {
                $currentDate = $startDate->copy()->startOfWeek();
                while ($currentDate->lte($endDate) && $contributionCount < $totalMembers) {
                    $weekStart = $currentDate->format('M d');
                    $weekEnd = $currentDate->copy()->endOfWeek()->format('M d, Y');
                    $weekFormat = "$weekStart - $weekEnd";

                    // Check if this specific contribution is paid
                    $isPaid = isset($paidContributions[$weekFormat]);
                    
                    $months[] = [
                        'name' => $single->user->name,
                        'period' => $weekFormat,
                        'amount' => $group->amount,
                        'uuid' => $group->uuid,
                        'paid' => $isPaid
                    ];

                    $contributionCount++;
                    $currentDate->addWeek();
                }
            } elseif ($mode == "Monthly") {
                $currentDate = $startDate->copy()->startOfMonth();
                while ($currentDate->lte($endDate) && $contributionCount < $totalMembers) {
                    $monthFormat = $currentDate->format('F Y');

                    // Check if this specific contribution is paid
                    $isPaid = isset($paidContributions[$monthFormat]);

                    $months[] = [
                        'name' => $single->user->name,
                        'period' => $monthFormat,
                        'amount' => $group->amount,
                        'uuid' => $group->uuid,
                        'paid' => $isPaid
                    ];

                    $contributionCount++;
                    $currentDate->addMonth();
                }
            } else { // Daily
                $currentDate = $startDate->copy()->startOfDay();
                while ($currentDate->lte($endDate) && $contributionCount < $totalMembers) {
                    $dayFormat = $currentDate->format('F d, Y');

                    // Check if this specific contribution is paid
                    $isPaid = isset($paidContributions[$dayFormat]);

                    $months[] = [
                        'name' => $single->user->name,
                        'period' => $dayFormat,
                        'amount' => $group->amount,
                        'uuid' => $group->uuid,
                        'paid' => $isPaid
                    ];

                    $contributionCount++;
                    $currentDate->addDay();
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
