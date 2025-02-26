<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\success_status_code;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;

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
        
                $weeks = [];
                // dd()
                foreach ($weeksToView as $thisWeek) {
                    $check = in_array($thisWeek, $myWeeks);
                    if (!$check) {
                        $months[] = ['source' => '1', 'week' => $thisWeek, "amount" => $single->amount, 'uuid' => $single->uuid];
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
        $data['months'] = $months;
        $data['user'] = Auth::user();
        return view ('ajo.admin.ajo.dues', $data);  
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
        return view('ajo.admin.ajopending',$data);
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
        $data['user'] = Auth::user();
        return view('ajo.my_group', $data);
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
