<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
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
        return view('admin.ajo.group');
    }

    public function view($id){
        // dd($id);
        $data['id'] =$id;
        return view('admin.ajo.group_view',$data);
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
