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
                    $modelIsPaid = $single->user->checkIfPaid($group->uuid, null, $weekFormat, null);
                   
                    
                    $months[] = [
                        'name' => $single->user->name,
                        'user' => $single->user,
                        'period' => $weekFormat,
                        'amount' => $group->amount,
                        'uuid' => $group->uuid,
                        'id' => $group->id,
                        'type' => 'weekly'
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
                        'user' => $single->user,
                        'period' => $monthFormat,
                        'amount' => $group->amount,
                        'uuid' => $group->uuid,
                        'id' => $group->id,
                        'type' => 'monthly'
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
                        'user' => $single->user,
                        'period' => $dayFormat,
                        'amount' => $group->amount,
                        'uuid' => $group->uuid,
                        'id' => $group->id,
                        'type' => 'daily'
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
