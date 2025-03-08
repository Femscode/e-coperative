<?php

namespace App\Http\Livewire;

use App\Models\Group;
use Livewire\Component;
use App\Models\GroupMember;

class AjoGroupMember extends Component
{
    public $memberId;
    public function mount($memberId)
    {
        $this->memberId = $memberId;
    }
    public function render()
    {
        $data['title'] = "Group Contributors";
        $data['group'] = $group = Group::where('uuid', $this->memberId)->first();
        // dd($this->memberId);
        $data['members'] = GroupMember::where('group_id', $group->id)->paginate(15);
        $data['nextMember'] = GroupMember::where('group_id', $group->id)->where('packed', 0)
        ->orderBy('turn', 'asc')
        ->first();
        return view('livewire.ajo-group-member', $data);
    }
}
