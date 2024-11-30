<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\MemberImport;
use App\Models\Bank;
use App\Models\Company;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\User;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('dashboard.member_list');
        return view('admin.member.list');
    }

    public function details($id)
    {
        $data['user'] = $user = User::find($id);
        $data['plan'] = $user->plan();
        $data['banks'] = Bank::orderBy('name', 'asc')->get();
        $data['coop'] = Company::find($user->company_id);
        // dd($plan);
        // return view('member.profile', $data);
        return view('dashboard.member_details', $data);
        return view('admin.member.detail', $data);
    }

    public function transactions($id)
    {
        $data['user'] = $user = User::find($id);
        $data['plan'] = $user->plan();
        $data['banks'] = Bank::orderBy('name', 'asc')->get();
        $data['coop'] = $company = Company::where('uuid',$user->company_id)->first();
        $data['transactions'] = Transaction::where('user_id', $user->id)->latest()->paginate(20);
        if(!$company) {
            $data['coop'] = Company::find($user->company_id);
        }
       
        // dd($plan);
        // return view('member.profile', $data);
        return view('dashboard.member_transactions', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(request()->file('file'));
        $highestRow = $spreadsheet->getActiveSheet()->getHighestDataRow();
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $countdata =  count($sheetData) - 1;

        if ($countdata < 1) {
            return api_request_response(
                "error",
                "Excel File Is Empty! Populate And Upload! ",
                success_status_code(),
                $countdata
            );
        }

        try {
            // dd($request->all());
            $plan = $request->plan_id;
            \Excel::import(new MemberImport($plan), request()->file('file'));

            return api_request_response(
                "ok",
                "Transaction successful!!",
                success_status_code(),
                $countdata
            );
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // DB::rollback();
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $errormess = '';
                foreach ($failure->errors() as $error) {
                    $errormess = $errormess . $error;
                }
                $errormessage[] = 'There was an error on Row ' . ' ' . $failure->row() . '.' . ' ' . $errormess;
            }

            return api_request_response(
                'error',
                $errormessage,
                bad_response_status_code()
            );
        } catch (\Exception $exception) {
            // DB::rollback();
            $errorCode = $exception->errorInfo[1] ?? $exception;
            if (is_int($errorCode)) {
                return api_request_response(
                    'error',
                    $errorCode,
                    bad_response_status_code()
                );
            } else {
                // dd($exception);
                return api_request_response(
                    'error',
                    $exception->getMessage(),
                    bad_response_status_code()
                );
            }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
