<?php

namespace App\Http\Controllers\Admin;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registration()
    {

        $data['title'] = "Registration Transactions";
        return view('cooperative.admin.registration', $data);
      
    }
    public function repayment()
    {

        $data['title'] = "Loan Repayment Transactions";
        return view('cooperative.admin.repayment', $data);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dues()
    {
        $data['title'] = "Monthly Dues Transactions";
        return view('cooperative.admin.dues', $data);
       
    }
    public function all()
    {
        $data['title'] = "All Transactions";
        return view('cooperative.admin.all', $data);
      
    }
    public function form()
    {
        $data['title'] = "Form Transactions";
        return view('cooperative.admin.form', $data);
     
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
