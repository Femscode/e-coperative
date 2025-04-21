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

        if ($this->search == '') {
            $data['transactions'] = Transaction::where('company_id', $company->uuid)
                ->where('status', 'Success')
                ->where('payment_type', 'Contribution-Dues')->paginate(10);
        } else {
            $data['transactions'] = Transaction::where('company_id', $company->uuid)
                ->where('status', 'Success')
                ->where('payment_type', 'Contribution-Dues')

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
