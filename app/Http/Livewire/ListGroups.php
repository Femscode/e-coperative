<?php

namespace App\Http\Livewire;

use App\Models\Group;
use App\Models\Company;
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
        $company = Company::where('uuid',$user->company_id)->first();
        if(!$company) {
            $company = Company::find($user->company_id);
        }
      
        if($this->search == ''){
            $data['loans'] = Group::where('company_id',$company->id)
            ->paginate(10);
        }else{
            $data['loans'] = Group::where('company_id',$company->id)->where(function ($query) {
                $query->where('applied_date', 'LIKE', '%' . $this->search . '%')
                ->orWhere('total_applied', 'LIKE', '%' . $this->search . '%')
                ->orWhere('monthly_return', 'LIKE', '%' . $this->search . '%')
                ->orWhere('status', 'LIKE', '%' . $this->search . '%');
            })
            ->paginate(10);
        }
        return view('livewire.list-groups', $data);
    }
}
