<?php

namespace App\Http\Livewire;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;
class RegistrationTransaction extends Component
{
    use WithPagination;

    public $search = '';
    public function paginationView()
    {
        return 'livewire.custom';
    }
    public function render()
    {
        $data['title'] = "Registration Transactions";
        if($this->search == ''){
            $data['transactions'] = Transaction::where([
                ['status', 'Success'],
                ['payment_type', 'Registration'],
            ])->paginate(10);
        }else{
            $data['transactions'] = Transaction::where(function ($query) {
                $query->where('status', 'Success')
                      ->where('payment_type', 'Registration');
            })
            ->where(function ($query) {
                $query->where('amount', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('month', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('updated_at', 'LIKE', '%' . $this->search . '%');
            })
            ->paginate(10);
        }
        return view('livewire.registration-transaction', $data);
    }
}
