<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class PendingMember extends Component
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
        $company = Company::where('uuid',$user->company_id)->first();
        
        
        if($this->search == ''){
            $data['members'] = User::where('company_id',$company->uuid)->where('user_type', "Member")->whereNull('status')->orderBy('created_at', 'desc')->paginate(12);
        }else{
            // dd($this->search);
            $data['members'] = User::where('company_id',$company->uuid)->where('user_type', "Member")->whereNull('status')->where('name', 'LIKE', '%' . $this->search . '%')->Orwhere('coop_id', 'LIKE', '%' . $this->search . '%')->Orwhere('email', 'LIKE', '%' . $this->search . '%')->orderBy('created_at', 'desc')->paginate(12);
        }
        return view('livewire.pending-member', $data);
    }
}
