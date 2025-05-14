<?php
// use Jenssegers\Agent\Facades\Agent;
use App\Models\Company;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\MemberLoan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WemaVirtualAccount;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;





// function audit($action, $modelType, $modelId, $oldValues = [], $newValues = [], $description = null, $agents = null)
// {
// $agent = new Agent();
// // Get device information
// $deviceName = $agent->device();
// // $deviceName = $device['device'];
// // Get operating system information
// $platform = $agent->platform();
// // Get browser information
// $browser = $agent->browser();
// $userAgent = $agent->getUserAgent();
// // dd($userAgent);
// //   $deviceName = Agent::device();
// //   $platform = Agent::platform();
// //   $browser = Agent::browser();
//     $userId = Auth::id();
//     $name = Auth::user()->first_name . ' '. Auth::user()->last_name;
//     DB::table('audit_trails')->insert([
//         'user_id' => $userId,
//         'action' => $action,
//         'description' => $description,
//         'model_type' => $modelType,
//         'url' => url()->current(),
//         'machine_name' => $deviceName . ' , ' . $platform . ' , ' . $browser . ' '. $userAgent,
//         'ip_address' => request()->ip(),
//         'model_id' => $modelId,
//         'old_values' => json_encode($oldValues),
//         'new_values' => json_encode($newValues),
//         'created_at' => now(),
//     ]);
// }

function getTotalDues($userId)
{
    $data['user'] = $user =  User::find($userId);
    $startDate = Carbon::parse($user->created_at);
    $endDate = Carbon::now();
    $mode = $user->plan()->mode;
    $data['plan'] = $plan =  $user->plan();
    //dd($mode);
    switch ($mode) {
        case 'Anytime':
            return 0;
            break;

        case 'Monthly':

            $currentDate = $startDate->copy()->startOfMonth();
            // dd($currentDate->lte($endDate),$currentDate->month,$endDate->month);
            while ($currentDate->lte($endDate) && ($currentDate->year < $endDate->year || ($currentDate->year == $endDate->year && $currentDate->month <= $endDate->month))) {
                $monthsToView[] = $currentDate->format('F Y');
                $currentDate->addMonth();
            }
            // dd($monthsToView);
            $myMonths = Transaction::where('user_id',  $userId)->where([['status', 'Success'], ['payment_type', 'Monthly Dues']])->pluck('month')->toArray();
            // dd($monthsToView, $myMonths);
            $months = [];
            foreach ($monthsToView as $thisMonth) {
                $check =  in_array($thisMonth, $myMonths);
                if ($check == false) {
                    $months[] = ['source' => '1', 'month' => $thisMonth, 'amount' => $plan->dues];
                }
            }
            // $data['months'] = $months ;

            // dd($dateArray);
            // $data['months'] = array_merge($months, $dateArray);
            $totalAmount = array_sum(array_column($months, 'amount')) ?? 0;

            return $totalAmount;
            // $data['months'] = $months + $dateArray;
            // dd($check, $data);
            // return view ('cooperative.member.admin.payment.monthly', $data);
            //return view ('member.payment.monthly', $data);
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
    $myWeeks = Transaction::where('user_id', $userId)
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
            $weeks[] = ['source' => '1', 'week' => $thisWeek, 'amount' => $plan->dues];
        }
    }
    // Calculate the total amount from the $weeks array
    $totalAmount = array_sum(array_column($weeks, 'amount')) ?? 0;

    return $totalAmount;
    //return array_sum($check['amount']) ?? 0 ;
    // dd($weeks);
}

function getContributionDues($userId)
{
    $user = User::find($userId);
    if (!$user) {
        return 0;
    }

    // Get groups the user is part of
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

    $totalDues = 0;
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
                    $totalDues += $group->amount;
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
                    $totalDues += $group->amount;
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
                    $totalDues += $group->amount;
                }
                $currentDate->addMonth();
            }
        }
    }

    return $totalDues;
}

function getTotalContributionCircles($userId)
{
    $user = User::find($userId);
    if (!$user) {
        return 0;
    }

    // Get the total amount from all active contribution circles the user belongs to
    $totalGroup = GroupMember::where('user_id', $user->id)
        ->join('groups', 'groups.id', '=', 'group_members.group_id')
        ->where('groups.status', 1)
        ->count();

    return $totalGroup;
}
function uploadImage($file, $path)
{
    $image_name = $file->getClientOriginalName();
    $image_name_withoutextensions = pathinfo($image_name, PATHINFO_FILENAME);
    $name = str_replace(" ", "", $image_name_withoutextensions);
    $image_extension = $file->getClientOriginalExtension();
    $file_name_extension = trim($name . '.' . $image_extension);
    $uploadedFile = $file->move(public_path($path), $file_name_extension);
    return $path . '/' . $file_name_extension;
}

function generate_slug_with_uuid_suffix($subject, $uuid)
{
    return Str::slug($subject) . "-" . str_replace(["-", "-"], "", $uuid);
}

function convertToUppercase($word)
{
    $words = explode(' ', $word);
    $result = '';
    foreach ($words as $word) {
        $result .= strtoupper(substr($word, 0, 1));
    }
    return $result;
    // return response()->json(['converted_word' => $result]);
}

