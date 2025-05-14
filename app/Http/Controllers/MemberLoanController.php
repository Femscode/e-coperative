<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\LoanPaymentTracker;
use App\Models\MemberLoan;
use App\Models\Plan;
use App\Models\Transaction;
use Carbon\Carbon;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use Illuminate\Http\Request;
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
        return view('cooperative.member.loan.index',$data);
      
        // dd($data);
    }
    public function ongoing()
    {
        $data['user'] = Auth::user();
        return view ('cooperative.member.loan.ongoing', $data);

        // dd($data);
    }
    public function completed()
    {
        $data['user'] = Auth::user();

        return view ('cooperative.member.loan.completed', $data);
       
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

    public function track(Request $request)
    {
        try {
            $check = LoanPaymentTracker::where('user_id', $request->user_id)->where('loan_id', $request->loan_id)->where('type', $request->type)->where('status',0)->first();
            if($check){
                return response()->json([
                    'success' => true,
                    'message' => 'Payment tracking already initiated',
                    'data' => $check
                ]);
            }
            $loan = MemberLoan::find($request->loan_id);
            $plan = Company::where('uuid',$loan->company_id);
            $tracker = LoanPaymentTracker::create([
                'user_id' => $request->user_id,
                'loan_id' => $request->loan_id,
                'type' => $request->type,
                'amount' => $plan->form_amount,
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment tracking initiated',
                'data' => $tracker
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to track payment: ' . $e->getMessage()
            ], 500);
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
