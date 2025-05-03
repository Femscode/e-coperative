<?php

namespace App\Http\Livewire;

use App\Models\Group;
use App\Models\GroupMember;
use Livewire\Component;

class MemberContributionLivewire extends Component
{
    public $search = '';
    public function paginationView()
    {
        return 'livewire.custom';
    }
    public function render()
    {
        $data['title'] = "My Circle(s)";
        $user = auth()->user();
        $getJoined = GroupMember::where('user_id', $user->id)->pluck('group_id')->toArray();
        if($this->search == ''){  
            $query = Group::where(function($q) use ($getJoined, $user) {
                $q->whereIn('id', $getJoined)
                  ->orWhere('company_id', $user->id);
            });
            
            $data['loans'] = $query->paginate(10);
        }else{
            $data['loans'] = Group::where('user_id',$getJoined)->where(function ($query) {
                $query->where('applied_date', 'LIKE', '%' . $this->search . '%')
                ->orWhere('total_applied', 'LIKE', '%' . $this->search . '%')
                ->orWhere('monthly_return', 'LIKE', '%' . $this->search . '%');
            })
            ->paginate(10);
        }
      
        return view('livewire.member-contribution-livewire',$data);
    }
}
