<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Transaction;
class RepaymentTransaction extends Component
{
    use WithPagination;

    public $search = '';
    public function paginationView()
    {
        return 'livewire.custom';
    }
    public function render()
    {
        $data['title'] = "Loan Repayment Transactions";
        if($this->search == ''){
            $data['transactions'] = Transaction::where([
                ['status', 'Success'],
                ['payment_type', 'Repayment'],
            ])->paginate(10);
        }else{
            $data['transactions'] = Transaction::where(function ($query) {
                $query->where('status', 'Success')
                      ->where('payment_type', 'Repayment');
            })
            ->where(function ($query) {
                $query->where('amount', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('month', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('updated_at', 'LIKE', '%' . $this->search . '%');
            })
            ->paginate(10);
        }
        return view('livewire.repayment-transaction', $data);
    }
}
