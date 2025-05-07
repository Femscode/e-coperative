<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\Group;
use App\Models\GroupMember;
use Livewire\Component;

class ListGroups extends Component
{
    public $search = '';
    public function paginationView()
    {
        return 'livewire.custom';
    }
    public function render()
    {
       
        $data['title'] = "Groups";
        $user = auth()->user();
        $getJoined = GroupMember::where('user_id', $user->id)->pluck('group_id')->toArray();
        if ($this->search == '') {

            $query = Group::where(function ($q) use ($getJoined, $user) {
                $q->whereIn('id', $getJoined)
                    ->orWhere('company_id', $user->id);
            });

            $data['loans'] = $query->paginate(10);
     
        } else {
            $data['loans'] = Group::where('company_id', $user->id)->where(function ($query) {
                $query
                ->where('applied_date', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('total_applied', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('monthly_return', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('status', 'LIKE', '%' . $this->search . '%');
            })
                ->paginate(10);
        }
        return view('livewire.list-groups', $data);
    }

    public function newrender()
    {
        $data['title'] = "Groups";
        $user = auth()->user();
        $getJoined = GroupMember::where('user_id', $user->id)->pluck('group_id')->toArray();
        
        if ($this->search == '') {
            $query = Group::where(function ($q) use ($getJoined, $user) {
                $q->whereIn('id', $getJoined)
                    ->orWhere('company_id', $user->id);
            });

            $data['groups'] = $query->paginate(10);
        } else {
            $query = Group::where(function ($q) use ($getJoined, $user) {
                $q->whereIn('id', $getJoined)
                    ->orWhere('company_id', $user->id);
            })->where(function ($query) {
                $query->where('title', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('amount', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('uuid', 'LIKE', '%' . $this->search . '%');
            });

            $data['groups'] = $query->paginate(10);
        }
        
        return view('livewire.list-groups', $data);
    }
}
