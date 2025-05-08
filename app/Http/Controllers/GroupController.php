<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Transaction;
use Carbon\Carbon;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data['groups'] = Group::where("company_id", auth()->user()->id)->get();
        return view('ajo.admin.ajo.group');
    }

    public function oldcontributionPayment()
    {

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
            ->select('uuid', 'week', 'month', 'day')
            ->get();

        // Create a lookup array for faster checking
        $paidContributions = [];


        foreach ($transactions as $transaction) {
            $periodValue = $transaction->day ?? $transaction->week ?? $transaction->month;
            $key = $transaction->uuid . '_' . $periodValue;
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

                    // $isPaid = isset($transactions[$single->uuid]) &&
                    //     $transactions[$single->uuid]->contains('month', $monthFormat);
                    $isPaid = isset($paidContributions[$single->uuid . '_' . $monthFormat]);
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


        $data['months'] = $allMonths;

        // Render view based on company type

        return view('ajo.admin.ajo.dues', $data);
    }



    public function contributionPayment()
    {
     
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

        // Fetch all paid contributions
        $transactions = Transaction::where('user_id', $user->uuid)
            ->where('status', 'Success')
            ->where('payment_type', 'Contribution')
            ->whereIn('uuid', $participation->pluck('uuid'))
            ->select('uuid', 'week', 'month', 'day')
            ->get();


        // Create a lookup array for faster checking
        $paidContributions = [];
        foreach ($transactions as $transaction) {
            $periodValue = $transaction->day ?? $transaction->week ?? $transaction->month;
            $key = $transaction->uuid . '_' . $periodValue;
            $paidContributions[$key] = true;
           
        }

        $allMonths = [];

        foreach ($participation as $single) {
            // Get total number of members in the group
            $totalMembers = GroupMember::where('group_id', $single->id)->count();
            $contributionCount = 0; // Track contributions for this member in this group

            $startDate = Carbon::parse($single->start_date);
            $endDate = Carbon::now();
            $mode = $single->mode;

            if ($mode == "Weekly") {
                $currentDate = $startDate->copy()->startOfWeek();
                while ($currentDate->lte($endDate) && $contributionCount < $totalMembers) {
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

                    $contributionCount++;
                    $currentDate->addWeek();
                }
            } elseif ($mode == "Monthly") {
                $currentDate = $startDate->copy()->startOfMonth();
                while ($currentDate->lte($endDate) && $contributionCount < $totalMembers) {
                    $monthFormat = $currentDate->format('F Y');

                    $isPaid = isset($paidContributions[$single->uuid . '_' . $monthFormat]);
                    $allMonths[] = [
                        'month' => $monthFormat,
                        'period' => $monthFormat,
                        'amount' => $single->amount,
                        'uuid' => $single->uuid,
                        'title' => $single->title,
                        'mode' => $mode,
                        'paid' => $isPaid
                    ];

                    $contributionCount++;
                    $currentDate->addMonth();
                }
            } else { // Daily
                $currentDate = $startDate->copy()->startOfDay();
                while ($currentDate->lte($endDate) && $contributionCount < $totalMembers) {
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

                    $contributionCount++;
                    $currentDate->addDay();
                }
            }
        }

        $data['months'] = $allMonths;

        // Render view based on company type
        return view('ajo.admin.ajo.dues', $data);
    }

    public function circleMembers($uuid)
    {
        $data['group'] = $group = Group::where('uuid', $uuid)->first();
        $data['id'] = $uuid;
        $user = Auth::user();
        if (!$group) {
            return redirect()->back();
        }
        if ($user->user_type == 'Member') {
            return view('ajo.member.circle_members', $data);
        } else {
            return view('ajo.circle_members', $data);
        }
    }

    public function view($id)
    {
        // dd($id);
        $data['id'] = $id;
        return view('ajo.admin.ajo.group_view', $data);
    }
    public function cDues($id)
    {
        $user = Auth::user();
        $data['id'] = $id;
        if ($user->user_type == 'Member') {
            return view('ajo.member.ajo_pending', $data);
        } else {
            return view('ajo.admin.ajo.pending', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $input = $request->all();
            $input['uuid'] = $uuid = rand();
            $gen = generate_slug_with_uuid_suffix($request->title, $uuid);
            $input['link'] = url('/') . '/join/contribution/' . "join" . "-" . $gen;
            // dd($input,);
            $input['amount'] = str_replace(',', '', $input['amount']);
            $group = Group::create($input);
            GroupMember::create([
                'user_id' => auth()->user()->id,
                'group_id' => $group->id,
                'turn' => $group->turn_type == 'random' ? null : 1, // First member gets first turn
            ]);
            return api_request_response(
                'ok',
                'Group saved successfully!',
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

    public function approve(Request $request)
    {

        try {
            $id = $request->id;
            $user = Auth::user();
            $group = Group::find($id);
            //verify if user is already part of this group
            $gMember = GroupMember::where('group_id', $group->id)->where('user_id', $user->id)->first();
            if ($gMember) {
                return api_request_response(
                    'error',
                    'You are already a member of this group!',
                    success_status_code()
                );
            }
            $countNumber = $group->members->count();
            if ($countNumber >= $group->max) {
                return api_request_response(
                    'error',
                    'Maximum member reached !',
                    success_status_code()
                );
            }
            if ($group->start_date) {
                return api_request_response(
                    'error',
                    'Contribution already ongoing !',
                    success_status_code()
                );
            }
            $number = $countNumber + 1;


            $application = GroupMember::create([
                "group_id" =>  $group->id,
                "user_id" =>  $user->id,
                "turn" => $group->turn_type == 'random' ? null : $number,
            ]);

            $message = "Welcome Onboard!";

            return api_request_response(
                'ok',
                $message,
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

    public function start(Request $request)
    {
        try {
            $id = $request->id;
            $user = Auth::user();
            $group = Group::find($id);
            //verify if user is already part of this group
            $gMember = GroupMember::where('group_id', $group->id)->where('user_id', $user->id)->first();
            if ($group->start_date) {
                return api_request_response(
                    'error',
                    'Contribution is already in progress!',
                    success_status_code()
                );
            }
            $countNumber = $group->members->count();
            if ($countNumber < 1) {
                return api_request_response(
                    'error',
                    'No member on this contribution yet !',
                    success_status_code()
                );
            }
            $mode = $group->mode;
            $startDate = Carbon::now(); // Start from today
            $use = clone $startDate;

            //update turn 

            if ($group->turn_type == 'random') {
                $members = $group->members;
                $members = $members->shuffle();
                $members->each(function ($member, $key) {
                    $member->turn = $key + 1;
                    $member->save();
                });
            }
            // dd($startDate);
            switch ($mode) {
                case 'Daily':
                    // Count today, so we subtract 1
                    $endDate = (clone $use)->addDays($countNumber - 1);
                    break;

                case 'Weekly':
                    if ($countNumber == 1) {
                        // Ends this week's Saturday
                        $endDate = (clone $use)->endOfWeek(Carbon::SATURDAY);
                    } else {
                        // Count this week, so add (members - 1) weeks
                        $endDate = (clone $use)->addWeeks($countNumber - 1)->endOfWeek(Carbon::SATURDAY);
                    }
                    break;

                case 'Monthly':
                    if ($countNumber == 1) {
                        // Ends this month's last day
                        $endDate = (clone $use)->endOfMonth();
                    } else {
                        // Count this month, so add (members - 1) months
                        $endDate = (clone $use)->addMonths($countNumber - 1)->endOfMonth();
                    }
                    break;

                    // default:
                    //     $endDate = $startDate; // Fallback (should not happen)
            }
            // dd($endDate,$startDate);
            $group->update(['status' => 1, 'end_date' => $endDate, "start_date" => $startDate]);
            $message = "Hurray! Contribution now in progress mode !";

            return api_request_response(
                'ok',
                $message,
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

    public function contribution()
    {
        $data['user'] = $user = Auth::user();
        if ($user->company->type == 2) {
            return view('ajo.member.my_group', $data);
        }
        return view('ajo.my_group', $data);
    }

    public function disburseContribution(Request $request)
    {
        try {
            $apiSecret = env('PAYSTACK_DISBURSE_SECRET_KEY');
            $client = new Client();
            // $paystack = new Paystack();
            $loanDetails = GroupMember::where('id', $request->id)->first();
            $user = $loanDetails->user;
            $name = $user->account_name;
            $code = $user->bank_code;
            $number = $user->account_number;
            $group = Group::find($loanDetails->group_id);
            $totalM = GroupMember::where('group_id', $group->id)->count();
            if (!$code) {
                return api_request_response(
                    'error',
                    "Member hasn't completed bank info to receive loan!",
                    success_status_code(),
                );
            }
            // $response = $client->post('https://api.paystack.co/transferrecipient', [
            //     'headers' => [
            //         'Authorization' => 'Bearer ' . $apiSecret,
            //         'Content-Type' => 'application/json',
            //     ],
            //     'json' => [
            //         'type' => 'nuban',
            //         'name' => $name,
            //         'description' => 'Recipient Description',
            //         'account_number' => $number,
            //         'bank_code' => $code,
            //     ],
            // ]);

            // $responseData = json_decode($response->getBody());

            // if ($responseData->status) {
            //     // Recipient created successfully
            //     $recipientCode = $responseData->data->recipient_code;
            //     $client = new Client();

            //     $response = $client->post('https://api.paystack.co/transfer', [
            //         'headers' => [
            //             'Authorization' => 'Bearer ' . $apiSecret,
            //             'Content-Type' => 'application/json',
            //         ],
            //         'json' => [
            //             'recipient' => $recipientCode,
            //             'amount' =>  $group->amount * $totalM * 100, // Amount in kobo (e.g., 10000 for ₦100)
            //             'source' => 'balance', // Amount in kobo (e.g., 10000 for ₦100)
            //         ],
            //     ]);
            //     $responseData = json_decode($response->getBody());
            //     if ($responseData->status) {
            // Transfer initiated successfully
            $loanDetails->update(['packed' => 1]);
            // You can save the transfer reference and status in your database for tracking
            return api_request_response(
                'ok',
                'Transfer initiated successfully!',
                success_status_code(),
            );
            // return redirect()->back()->with('success', 'Transfer initiated successfully');
            // } else {
            //     // Handle the error
            //     return api_request_response(
            //         'error',
            //         $responseData->message,
            //         bad_response_status_code()
            //     );
            //     // return redirect()->back()->with('error', $transfer->data->message);
            // }

            // return redirect()->back()->with('success', 'Recipient created successfully');
            // } else {
            //     // Handle the error
            //     return api_request_response(
            //         'error',
            //         $responseData->message,
            //         bad_response_status_code()
            //     );
            //     // return redirect()->back()->with('error', $recipient->data->message);
            // }
        } catch (\Exception $exception) {
            return api_request_response(
                'error',
                $exception->getMessage(),
                bad_response_status_code()
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }
}
