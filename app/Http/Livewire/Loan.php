<?php

namespace App\Http\Livewire;
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
        if($this->search == ''){
            $data['loans'] = MemberLoan::where('company_id',$user->company_id)->paginate(10);
        }else{
            $data['loans'] = MemberLoan::where('company_id',$user->company_id)->where(function ($query) {
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
