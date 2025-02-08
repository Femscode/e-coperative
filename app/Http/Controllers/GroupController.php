<?php

namespace App\Http\Controllers;

use App\Models\Group;
use function App\Helpers\success_status_code;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use Illuminate\Http\Request;

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
            $input['link'] = url('/'). '/' ."join"."-".$gen;
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
