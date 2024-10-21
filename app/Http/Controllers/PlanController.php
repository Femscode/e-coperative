<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function planDetails(Request $request){
        $data['plan'] = $plan = Plan::where('id', $request->id)->first();
        if($plan){
            $currentMonth = Carbon::now()->month;
            // Create a Carbon instance for the first day of the current month
            $firstDayOfMonth = Carbon::createFromDate(null, $currentMonth, 1);

            // Get the day of the week for the first day of the month (0=Sunday, 1=Monday, etc.)
            $firstDayOfWeek = $firstDayOfMonth->dayOfWeek;

            // Calculate the number of Mondays in the month based on the day of the week for the first day
            $numMondays = intval($firstDayOfMonth->daysInMonth / 7) + ($firstDayOfWeek <= Carbon::MONDAY && ($firstDayOfMonth->daysInMonth % 7 >= Carbon::MONDAY - $firstDayOfWeek));
            $data['current'] =$plan->monthly_dues * $numMondays  ;
            $data['month'] =$plan->monthly_dues * $numMondays +  $plan->monthly_charge ;
            $data['amount'] = $plan->monthly_dues * $numMondays + $plan->reg_fee + $plan->monthly_charge;
        }else{
            $data['month'] = "";
            $data['amount'] = "";
            $data['current'] = "";
        }
        // dd($data);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
