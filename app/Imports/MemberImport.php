<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\Member;
use App\Models\NumberCount;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MemberImport implements ToCollection, WithBatchInserts, WithHeadingRow, WithChunkReading
{
    protected $plan;

    function __construct($plan)
    {
        $this->plan = $plan;
    }
    public function collection(Collection $rows)
    {
        set_time_limit(400);
        foreach ($rows as $row) {
            // dd($this->plan);
            if (empty($row['name'])) {
                continue;
            }
            // $checkMember = Member::where('coop_id', $row['mem_id'])->first();
            // if($checkMember){
            //     return null;
            // }
            // if(empty($row['email'])){
            $admin = $user = Auth::user();
            $company = $coopD = Company::where('uuid', $user->company_id)->first();
            if (!$company) {
                $company = $coopD =Company::find($user->company_id);
            }
           
            $checkNumber =  NumberCount::where('coop_id', $admin->company_id)->first();

            // attempt to give new member coop id
            if ($checkNumber) {
                $code = $checkNumber->count + 1;
                $checkNumber->update([
                    "count" => $checkNumber->count + 1,
                ]);
            } else {
                $code = 1;
                NumberCount::create([
                    "count" => 1,
                    'coop_id' => $admin->company_id
                ]);
            }
            $check = User::where('email', $row['email'])->first();
            // $checkmail = User::where('email', $row['email'])->first();
            // if(!$check && !$checkmail){
            if (!$check) {
                $fullName = $row['name'];
                // Use the explode function to split the full name into an array of words
                $words = explode(' ', $fullName);
                // Extract the first word and convert it to lowercase
                $firstWord = strtolower($words[0]) . '' . "@e-coop" . '' . convertToUppercase($coopD->name) . '' . $code . '' . ".com";
                // $checkMember = User::where('email', $firstWord)->where('coop_id','!=', $row['mem_id'])->first();
                // if($checkMember){
                //     $firstWord = strtolower($words[1]).''."@onemillionhands.com";
                // }
                $user = User::create([
                    'name' => $row['name'],
                    'coop_id' => convertToUppercase($coopD->name) . '' . $code,
                    'email' => $row['email'] ?? $firstWord,
                    'password' => bcrypt(strtolower($words[0])),
                    'user_type' => "Member",
                    'plan_id' => $this->plan,
                    'company_id' => $company->id,
                    'phone' => $row['phone_number'],
                    'address' => $row['address'] ?? ""
                    // 'role' => 1,
                    // 'company_id' => Auth::user()->company_id,
                    // 'last_login' => now(),
                ]);
            }
            // }
            // $member = Member::create([
            //     'name' => $row['name'], // names in the database table the first (firstname)  // names in the excel inside array[]
            //     'coop-id' => $row['coop_id'],
            //     'email' => $row['email'] ?? NULL,
            //     'registered_at' => now(),
            //     // 'company_id' => Auth::user()->company_id,
            // ]);

        }
    }


    // public function rules(): array
    // {
    //     return [
    //         //columns in the excel
    //         'name' => 'required|max:500|nullable',
    //         // 'mem_no' => 'required|numeric|unique:App\Models\Membership,member_id|unique:App\Models\User,employee_id',
    //         // 'email' => "unique:App\Models\Membership,email|unique:App\Models\User,email|email|nullable",
    //         // 'commodity' => "numeric|nullable",

    //     ];
    // }

    // public function customValidationMessages(): array
    // {
    //     return [
    //         //All Email Validation for Staff
    //         'name.required' => ' Member Name must not be empty!',
    //         // 'mem_no.unique'    => 'Member No Already Exists!',
    //     ];
    // }

    public function chunkSize(): int
    {
        return 300;
    }

    public function batchSize(): int
    {
        return 300;
    }
}
