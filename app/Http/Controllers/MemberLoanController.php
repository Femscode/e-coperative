<?php

namespace App\Http\Controllers;
use App\Models\MemberLoan;
use App\Models\Transaction;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MemberLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['user'] = $user =  Auth::user();
        $data['transactions'] = Transaction::where('user_id',  $user->id)->orWhere('email', $user->email)->where('status', 'Success')->latest()->get();
       
        // dd($data);
        return view ('member_dashboard.loan.index',$data);
        return view ('loan.index',$data);
        // dd($data);
    }
    public function ongoing()
    {
        $data['user'] = Auth::user();

        return view ('loan.ongoing',$data);
        // dd($data);
    }
    public function completed()
    {
        $data['user'] = Auth::user();

        return view ('loan.completed',$data);
        // dd($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apply(Request $request)
    {
        try {
            $verify = MemberLoan::where('user_id', auth()->user()->id)->wherein('status', ["Awaiting","Ongoing"])->first();
            $verifyStatus = MemberLoan::where('user_id', auth()->user()->id)->where('status', "Awaiting")->first();
            if($verify){
                if($verifyStatus){
                    $status = "Pending";
                }else{
                    $status = "Ongoing";
                }
                return api_request_response(
                    'error',
                    "You Have A $status Loan Application!",
                    bad_response_status_code()
                );
            }
            $input = $request->all();
            $input['total_applied'] = str_replace(',', '', $input['total_applied']);
            $input['monthly_return'] = str_replace(',', '', $input['monthly_return']);
            $input['total_left'] = str_replace(',', '', $input['total_applied']);
            $loan = MemberLoan::create($input);
            return api_request_response(
                'ok',
                'Application Successful, You Will Be Notified When Approved!',
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
     * @param  \App\Models\MemberLoan  $memberLoan
     * @return \Illuminate\Http\Response
     */
    public function show(MemberLoan $memberLoan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MemberLoan  $memberLoan
     * @return \Illuminate\Http\Response
     */
    public function edit(MemberLoan $memberLoan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MemberLoan  $memberLoan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemberLoan $memberLoan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemberLoan  $memberLoan
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberLoan $memberLoan)
    {
        //
    }
}
