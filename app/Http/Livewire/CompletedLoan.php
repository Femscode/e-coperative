<?php

namespace App\Http\Livewire;

use App\Models\Company;
use Livewire\Component;
use App\Models\MemberLoan;

class CompletedLoan extends Component
{
    public $search = '';
    public function paginationView()
    {
        return 'livewire.custom';
    }
    public function render()
    {
        $data['title'] = "Completed Applications";
        $user = auth()->user();
        $company = Company::where('uuid', $user->company_id)->first();
        
        if($this->search == ''){
            $data['loans'] = MemberLoan::where('company_id',$company->id)->where('status', "Completed")->paginate(10);
        }else{
            $data['loans'] = MemberLoan::where('company_id',$company->id)->where('status', "Completed")->where(function ($query) {
                $query->where('applied_date', 'LIKE', '%' . $this->search . '%')
                ->orWhere('total_applied', 'LIKE', '%' . $this->search . '%')
                ->orWhere('monthly_return', 'LIKE', '%' . $this->search . '%');
            })
            ->paginate(10);
        }
        return view('livewire.completed-loan', $data);
    }
}
