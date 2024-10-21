<?php

namespace App\Http\Controllers;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use App\Models\Activity;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data['now'] = date('Y-m-d', strtotime(now()));
        $data['activities'] = Activity::all();
        $data['users'] = User::where('user_type', 'member')->get();
        return view('activities_home', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        try{
            $extensions = [
                'jpg' => 'jpeg.png',
                'png' => 'png.png',
                'pdf' => 'pdfdocument.png',
                'doc' => 'wordicon.jpg',
            ];
            $countCurrentDateActivity = Activity::whereDate('created_at', date('Y-m-d'))->count();
            if($countCurrentDateActivity == 4){
                return redirect()->back()->withErrors(['exception' => "Maximum Activity For Today Created"]); 
            }
            $input = $request->all();
            if ($request->has('image')) {
                $input['image'] = $pic =  time() . '.' . $request->image->extension();
                $request->image->move(public_path('file'), $pic);
            }
            if($request->is_global){
                $input['is_global'] = 1;
                $input['user_id'] = 1;
            }else{
                $input['is_global'] = 0;
                $input['user_id'] = $request->user_id;
            }
            $user = Activity::create($input);
            
            return redirect()->back()->with('message', 'Activity created successfully');

        } catch (\Exception $exception) {

            return redirect()->back()->withErrors(['exception' => $exception->getMessage()]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {
        $user = Activity::where('id', $request->id)->first();

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function updateActivity(Request $request)
    { 
        try {

            $activity = Activity::find($request->id);
           
                $input = $request->all();
                
                $activity->update($request->all());
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        $activity = Activity::find($id);
        // dd($customer);
        $activity->delete();

        return redirect()->back()->with('message', 'Activity deleted successfully');
    }
    
}
