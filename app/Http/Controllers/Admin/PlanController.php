<?php

namespace App\Http\Controllers\Admin;
use App\Models\Plan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;

class PlanController extends Controller
{
    public function index(){
        $data['plans'] = Plan::orderBy('created_at', 'desc')->get();
        return view('dashboard.plan', $data);
        return view('admin.plan.index', $data);
    }

    public function create(Request $request){
        try {
            $input = $request->all();
            if($request->has('id')){
                $plan = Plan::where('id', $input['id'])->first();
                $plan->update($input);
                return api_request_response(
                    'ok',
                    'Record updated successfully!',
                    success_status_code(),
                );
            }
                $user = Plan::create($input);
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
