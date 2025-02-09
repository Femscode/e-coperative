<?php
// use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\DB;
use App\Models\WemaVirtualAccount;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\MemberLoan;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
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
            switch($mode){
                case 'Anytime':
                   return 0;
                    break;
    
                case 'Monthly':
    
                    $currentDate = $startDate->copy()->startOfMonth();
                    // dd($currentDate->lte($endDate),$currentDate->month,$endDate->month);
                    while ($currentDate->lte($endDate) &&($currentDate->year < $endDate->year || ($currentDate->year == $endDate->year && $currentDate->month <= $endDate->month))) {
                        $monthsToView[] = $currentDate->format('F Y');
                        $currentDate->addMonth();
                    }
                    // dd($monthsToView);
                    $myMonths = Transaction::where('user_id',  $userId)->where([['status', 'Success'],['payment_type','Monthly Dues']])->pluck('month')->toArray();
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
                   // return view ('member_dashboard.payment.monthly', $data);
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
            return Str::slug($subject)."-".str_replace(["-", "-"], "", $uuid);
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
