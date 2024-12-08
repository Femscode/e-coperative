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
            $data['loans'] = MemberLoan::where('user_id', auth()->user()->id)
            ->where(function ($query) {
                $query->where('approval_status', 0)
                ->OrWhere('payment_status', 0);
            })
            ->paginate(10);
        }else{
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
        return view('livewire.loan-application', $data);
    }
}
