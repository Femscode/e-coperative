<?php

namespace App\Http\Livewire;
use App\Models\ErrorLog;
use Livewire\Component;
use Livewire\WithPagination;

class ErrorLogs extends Component
{
    use WithPagination;

    public $search = '';

    public function paginationView()
    {
        return 'livewire.custom';
    }
    public function render()
    {
        // dd("here");

        if($this->search == ''){
            $data['errors'] = ErrorLog::select('url','email','created_at')->paginate(10);
            // dd($data);
        }else{
            $data['errors'] = ErrorLog::select('url','email','created_at')->where(function ($query) {
                $query->where('email', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('created_at', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('url', 'LIKE', '%' . $this->search . '%');
            })
            ->paginate(10);
        }
        // dd($data);
        return view('livewire.error-logs', $data);
    }
}
