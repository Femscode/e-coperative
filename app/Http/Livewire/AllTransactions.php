<?php

namespace App\Http\Livewire;
use App\Models\Company;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;

class AllTransactions extends Component
{
    use WithPagination;

    public $search = '';
    public function paginationView()
    {
        return 'livewire.custom';
    }
    public function render()
    {
        $data['title'] = "All Transactions";
        $user = auth()->user();
        $company = Company::where('uuid', $user->company_id)->first();
        if(!$company) {
            $company = Company::find($user->company_id);
        }
        if($this->search == ''){
            $data['transactions'] = Transaction::where('company_id',$company->id)->where([
                ['status', 'Success'],
            ])->paginate(10);
        }else{
            $data['transactions'] = Transaction::where('company_id',$company->id)->where(function ($query) {
                $query->where('status', 'Success');
            })
            ->where(function ($query) {
                $query->where('amount', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('month', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('updated_at', 'LIKE', '%' . $this->search . '%');
            })
            ->paginate(10);
        }
        return view('livewire.all-transactions', $data);
    }
}
