<?php

namespace App\Http\Livewire;
use App\Models\Company;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;

class MonthlyTransactions extends Component
{
    use WithPagination;

    public $search = '';
    public function paginationView()
    {
        return 'livewire.custom';
    }
    public function render()
    {
        $data['title'] = "Monthly Dues Transactions";
        $user = auth()->user();
        $company = Company::where('uuid', $user->company_id)->first();
        if($this->search == ''){
            $data['transactions'] = Transaction::where('company_id',$company->id)->where([
                ['status', 'Success'],
                // ['payment_type', 'Monthly Dues'],
            ])->whereIn('payment_type', ['Weekly Dues','Monthly Dues','Funding','Anytime'])->paginate(10);
        }else{
            $data['transactions'] = Transaction::where('company_id',$company->id)->where(function ($query) {
                $query->where('status', 'Success')
                ->whereIn('payment_type', ['Weekly Dues','Monthly Dues','Funding','Anytime']);
            })
            ->where(function ($query) {
                $query->where('amount', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('month', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('updated_at', 'LIKE', '%' . $this->search . '%');
            })
            ->paginate(10);
        }
        return view('livewire.monthly-transactions', $data);
    }
}
