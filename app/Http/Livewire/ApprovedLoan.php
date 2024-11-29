<?php

namespace App\Http\Livewire;

use App\Models\Company;
use Livewire\Component;
use App\Models\MemberLoan;

class ApprovedLoan extends Component
{
    public $search = '';
    public function paginationView()
    {
        return 'livewire.custom';
    }
    public function render()
    {
        $data['title'] = "Awaiting Disbursement Applications";
        $user = auth()->user();
        $company = Company::where('uuid', $user->company_id)->first();
        if($this->search == ''){
            $data['loans'] = MemberLoan::where('company_id',$company->id)->where('approval_status', 1)->where('payment_status', 1)->where('status', "Awaiting")->paginate(10);
        }else{
            $data['loans'] = MemberLoan::where('company_id',$company->id)->where('approval_status', 1)->where('payment_status', 1)->where('status', "Awaiting")->where(function ($query) {
                $query->where('applied_date', 'LIKE', '%' . $this->search . '%')
                ->orWhere('total_applied', 'LIKE', '%' . $this->search . '%')
                ->orWhere('monthly_return', 'LIKE', '%' . $this->search . '%');
            })
            ->paginate(10);
        }
        return view('livewire.approved-loan', $data);
    }
}
