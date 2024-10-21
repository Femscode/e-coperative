<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Referral extends Component
{
    public $user;

    public function mount($user)
    {
        $this->user = $user;
    }
    public function render()
    {
        // dd($this->user);
        $user = $this->user;
        $data['refers'] = $user->refers();
        return view('livewire.referral', $data);
    }
}
