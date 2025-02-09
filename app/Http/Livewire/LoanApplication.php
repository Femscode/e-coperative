<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\MemberLoan;
use Carbon\Carbon;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LoanApplication extends Component
{
    use WithPagination;

    public $filter = '';
    public function paginationView()
    {
        return 'livewire.custom';
    }
    public function render()
    {
        $data['title'] = "Applications";
        $data['user'] = $user = auth()->user();

        if ($this->filter == '') {
            $data['loans'] = MemberLoan::where('user_id', auth()->user()->id)
                ->where(function ($query) {
                    $query->where('approval_status', 0)
                        ->OrWhere('payment_status', 0);
                })
                ->paginate(10);
        } else {
            $data['loans'] = MemberLoan::where('user_id', auth()->user()->id)->where(function ($query) {
                $query->where('approval_status', 0)
                    ->OrWhere('payment_status', 0);
            })
                ->where(function ($query) {
                    $query->where('applied_date', 'LIKE', '%' . $this->filter . '%')
                        ->orWhere('total_applied', 'LIKE', '%' . $this->filter . '%')
                        ->orWhere('monthly_return', 'LIKE', '%' . $this->filter . '%')
                        ->orWhere('status', 'LIKE', '%' . $this->filter . '%');
                })
                ->paginate(10);
            // dd($data);
        }
        // this is the data for ongoing loan
        $data['company'] = $company = Company::where('uuid', $user->company_id)->first();
        if (!$company) {
            $data['company'] = $company = Company::find($user->company_id);
        }
        // dd($data);
        $data['ongoing_loans'] = MemberLoan::where('user_id', auth()->user()->id)->where('company_id', $company->id)->where('status', "Ongoing")->paginate(10);
        $createdAt = auth()->user()->created_at;
        // Calculate the number of months between created_at and now
        $data['difference'] = $createdAt->diffInMonths(Carbon::now());
        return view('livewire.loan-application', $data);
    }
}
