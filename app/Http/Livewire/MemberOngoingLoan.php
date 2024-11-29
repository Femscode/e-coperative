<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\MemberLoan;

class MemberOngoingLoan extends Component
{
    use WithPagination;

    public $filter = '';
    public function paginationView()
    {
        return 'livewire.custom';
    }
    public function render()
    {
        $data['title'] = "Ongoing Applications";
        $user = auth()->user();
        if($this->filter == ''){
            $data['loans'] = MemberLoan::where('user_id', auth()->user()->id)
            ->where(function ($query) {
                $query->where('status', "Ongoing");
            })
            ->paginate(10);
        }else{
            $data['loans'] = MemberLoan::where('user_id', auth()->user()->id)->where(function ($query) {
                $query->where('status', "Ongoing");
            })
            ->where(function ($query) {
                $query->where('applied_date', 'LIKE', '%' . $this->filter . '%')
                      ->orWhere('total_applied', 'LIKE', '%' . $this->filter . '%')
                      ->orWhere('monthly_return', 'LIKE', '%' . $this->filter . '%');
            })
            ->paginate(10);
            // dd($data);
        }
        return view('livewire.member-ongoing-loan', $data);
    }
}
