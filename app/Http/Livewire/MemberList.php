<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class MemberList extends Component
{
    use WithPagination;

    public $search = '';
    public function paginationView()
    {
        return 'livewire.custom';
    }
    public function render()
    {
        $user = auth()->user();
        $company = Company::where('uuid', $user->company_id)->first();
        if($this->search == ''){
            $data['members'] = User::where('company_id',$company->id)->where('user_type', "Member")->orderBy('created_at', 'desc')->paginate(21);
        }else{
            // dd($this->search);
            $data['members'] = User::where('company_id',$company->id)->where('user_type', "Member")->where('name', 'LIKE', '%' . $this->search . '%')->Orwhere('coop_id', 'LIKE', '%' . $this->search . '%')->Orwhere('email', 'LIKE', '%' . $this->search . '%')->orderBy('created_at', 'desc')->paginate(21);
        }
        // dd($data);
        return view('livewire.member-list',$data);
    }
}
