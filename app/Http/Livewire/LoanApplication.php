<?php

namespace App\Http\Livewire;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MemberLoan;
use Auth;

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
        $user = auth()->user();
        if($this->filter == ''){
            $data['loans'] = MemberLoan::where('company_id',$user->company_id)->where('user_id', auth()->user()->id)->paginate(10);
        }else{
            $data['loans'] = MemberLoan::where('company_id',$user->company_id)->where(function ($query) {
                $query->where('user_id', auth()->user()->id);
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
        return view('livewire.loan-application', $data);
    }
}
