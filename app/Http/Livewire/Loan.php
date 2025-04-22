<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\MemberLoan;
use Livewire\Component;
use Livewire\WithPagination;

class Loan extends Component
{
    
    public $search = '';
    public function paginationView()
    {
        return 'livewire.custom';
    }
    public function render()
    {
        $data['title'] = "Loan Applications";
        $user = auth()->user();
        $company = Company::where('uuid',$user->company_id)->first();
        
      
        if($this->search == ''){
            $data['loans'] = MemberLoan::where('company_id',$company->uuid)
            ->where(function ($query) {
                $query->where('approval_status', 0)
                ->OrWhere('approval_status', 1);
            })
            ->where(function ($query) {
                $query->where('payment_status', 0);
            })
            ->paginate(10);
        }else{
            $data['loans'] = MemberLoan::where('company_id',$company->uuid)->where(function ($query) {
                $query->where('applied_date', 'LIKE', '%' . $this->search . '%')
                ->orWhere('total_applied', 'LIKE', '%' . $this->search . '%')
                ->orWhere('monthly_return', 'LIKE', '%' . $this->search . '%')
                ->orWhere('status', 'LIKE', '%' . $this->search . '%');
            })
            ->paginate(10);
        }
        return view('livewire.loan', $data);
    }
}
