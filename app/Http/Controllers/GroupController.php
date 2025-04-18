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

    public function oldcontributionPayment(){
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
        
                $weeks = [];
                // dd()
                foreach ($weeksToView as $thisWeek) {
                    
                    $check = in_array($thisWeek, $myWeeks);
                    if (!$check) {
                        $months[] = ['source' => '1', 'week' => $thisWeek, "amount" => $single->amount, 'uuid' => $single->uuid, 'title' => $single->title];
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
                        $months[] = ['source' => '1', 'month' => $thisMonth, "amount" => $single->amount, 'uuid' => $single->uuid, 'title' => $single->title];
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
                        $months[] = ['source' => '1', 'month' => $thisMonth, "amount" => $single->amount, 'uuid' => $single->uuid, 'title' => $single->title];
                    }
                }
            }

        }
        $data['months'] = $months;
        $data['user'] = Auth::user();
       
        
        return view ('ajo.admin.ajo.dues', $data);  
    }

    public function contributionPayment(){
        $groups = GroupMember::where('user_id', Auth::user()->id)
            ->select('group_id')
            ->distinct()
            ->pluck('group_id')
            ->toArray();
        
        $participation = Group::whereIn('id', $groups)->where('status', 1)->get();
        $months = [];
    
        foreach($participation as $single){
            $startDate = Carbon::parse($single->start_date);
            $endDate = Carbon::now();
            $mode = $single->mode;
    
            if($mode == "Weekly"){
                $currentDate = $startDate->copy()->startOfWeek();
                $weeksToView = [];
        
                while ($currentDate->lte($endDate)) {
                    $weekStart = $currentDate->format('M d');
                    $weekEnd = $currentDate->copy()->endOfWeek()->format('M d, Y');
                    $weeksToView[] = "$weekStart - $weekEnd";
                    $currentDate->addWeek();
                }
    
                $myWeeks = Transaction::where('user_id', auth()->user()->id)
                    ->where([
                        ['status', 'Success'],
                        ['payment_type', 'Contribution']
                    ])
                    ->pluck('month')
                    ->toArray();
        
                foreach ($weeksToView as $thisWeek) {
                    $check = in_array($thisWeek, $myWeeks);
                    if (!$check) {
                        $months[] = [
                            'source' => '1',
                            'week' => $thisWeek,
                            'amount' => $single->amount,
                            'uuid' => $single->uuid,
                            'title' => $single->title,
                            'mode' => $mode
                        ];
                    }
                }
            } elseif ($mode == "Monthly") {
                $monthsToView = [];
                $currentDate = $startDate->copy()->startOfMonth();
    
                while ($currentDate->lte($endDate) && ($currentDate->year < $endDate->year || ($currentDate->year == $endDate->year && $currentDate->month <= $endDate->month))) {
                    $monthsToView[] = $currentDate->format('F Y');
                    $currentDate->addMonth();
                }
    
                $myMonths = Transaction::where('user_id', auth()->user()->id)
                    ->where([
                        ['status', 'Success'],
                        ['payment_type', 'Contribution']
                    ])
                    ->pluck('month')
                    ->toArray();
    
                foreach ($monthsToView as $thisMonth) {
                    $check = in_array($thisMonth, $myMonths);
                    if (!$check) {
                        $months[] = [
                            'source' => '1',
                            'month' => $thisMonth,
                            'amount' => $single->amount,
                            'uuid' => $single->uuid,
                            'title' => $single->title,
                            'mode' => $mode
                        ];
                    }
                }
            } else { // Daily
                $monthsToView = [];
                $currentDate = $startDate->copy()->startOfDay();
    
                while ($currentDate->lte($endDate)) {
                    $monthsToView[] = $currentDate->format('F d, Y');
                    $currentDate->addDay();
                }
    
                $myMonths = Transaction::where('user_id', auth()->user()->id)
                    ->where([
                        ['status', 'Success'],
                        ['payment_type', 'Contribution']
                    ])
                    ->pluck('month')
                    ->toArray();
    
                foreach ($monthsToView as $thisMonth) {
                    $check = in_array($thisMonth, $myMonths);
                    if (!$check) {
                        $months[] = [
                            'source' => '1',
                            'month' => $thisMonth,
                            'amount' => $single->amount,
                            'uuid' => $single->uuid,
                            'title' => $single->title,
                            'mode' => $mode
                        ];
                    }
                }
            }
        }
    
        return view('ajo.admin.ajo.dues', [
            'months' => $months,
            'user' => Auth::user()
        ]);
    }


    public function circleMembers($uuid){
        $data['group'] = $group = Group::where('uuid', $uuid)->first();
        $data['id'] = $uuid;
        if(!$group){
            return redirect()->back();
        }
        return view('ajo.circle_members', $data);
    }

    public function view($id){
        // dd($id);
        $data['id'] =$id;
        return view('ajo.admin.ajo.group_view',$data);
    }
    public function cDues($id){
       
        $data['id'] =$id;
        return view('ajo.admin.ajo.pending',$data);
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
            $gen = generate_slug_with_uuid_suffix($request->title,$uuid);
            $input['link'] = url('/'). '/join/contribution/' ."join"."-".$gen;
            // dd($input,);
            $input['amount'] = str_replace(',', '', $input['amount']);
            Group::create($input);
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

    public function approve(Request $request){
      
        try {
            $id = $request->id;
            $user = Auth::user();
            $group =Group::find($id);
            //verify if user is already part of this group
            $gMember = GroupMember::where('group_id', $group->id)->where('user_id', $user->id)->first();
            if($gMember){
                return api_request_response(
                    'error',
                    'You are already a member of this group!',
                    success_status_code()
                );
            }
            $countNumber = $group->members->count();
            if($countNumber >= $group->max){
                return api_request_response(
                    'error',
                    'Maximum member reached !',
                    success_status_code()
                );
            }
            if($group->start_date){
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
                "turn" => $number, 
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

    public function start(Request $request){
        try {
            $id = $request->id;
            $user = Auth::user();
            $group =Group::find($id);
            //verify if user is already part of this group
            $gMember = GroupMember::where('group_id', $group->id)->where('user_id', $user->id)->first();
            if($group->start_date){
                return api_request_response(
                    'error',
                    'Contribution is already in progress!',
                    success_status_code()
                );
            }
            $countNumber = $group->members->count();
            if($countNumber < 1){
                return api_request_response(
                    'error',
                    'No member on this contribution yet !',
                    success_status_code()
                );
            }
            $mode = $group->mode;
            $startDate = Carbon::now(); // Start from today
            $use = clone $startDate;
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
            $group->update(['status' => 1,'end_date' => $endDate, "start_date" => $startDate]);
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

    public function contribution(){
        $data['user'] = $user = Auth::user();
        if($user->company->type == 2) {

            return view('ajo.member.my_group', $data);
        }
        return view('ajo.my_group', $data);
    }

    public function disburseContribution(Request $request){
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
            if(!$code){
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
