<?php

namespace App\Http\Livewire;
use App\Models\GroupMember;
use Livewire\Component;
use App\Models\Group;

class CircleMembers extends Component
{
    public $uuid;
    public function mount($uuid)
    {
        $this->uuid = $uuid;
    } 
    public function render()
    {
        $data['title'] = "Circle Contributors";
        $data['group'] = $group = Group::where('uuid', $this->uuid)->first();
        // dd($this->uuid);
        $data['members'] = GroupMember::where('group_id', $group->id)->paginate(15);
        return view('livewire.circle-members', $data);
    }
}
