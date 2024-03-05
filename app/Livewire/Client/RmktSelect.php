<?php

namespace App\Livewire\Client;

use App\Models\client;
use Livewire\Component;

class RmktSelect extends Component
{
    
    public function mount($phone){
        $clent = client::where('phone',$phone)->firstOrFail();
        dd($clent );

    }
    public function render()
    {
        return view('livewire.client.rmkt-select');
    }
}
