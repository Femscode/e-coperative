<?php

namespace App\Http\Controllers\Admin;
use App\Models\Plan;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function App\Helpers\success_status_code;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;

class PlanController extends Controller
{
    public function index(){
        $data['plan'] = Company::where('uuid', auth()->user()->company_id)->first();
        // dd($data);
        return view('admin.plan.index', $data);
    }

    public function create(Request $request){
        try {
            $input = $request->all();
            $company = Company::where('uuid', auth()->user()->company_id)->first();
            $company->update($input);
            return api_request_response(
                'ok',
                'Record saved successfully!',
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

    public function edit(Request $request){
        $plan = Plan::where('id', $request->id)->first();

        return response()->json($plan);
    }
}
