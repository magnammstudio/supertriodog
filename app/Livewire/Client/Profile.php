<?php

namespace App\Livewire\Client;

use App\Models\client;
use Livewire\Component;

class Profile extends Component
{
    public client $client;

    public function mount($client_code=null){
        $this->client = client::where('client_code',$client_code)->firstOrFail();
    }
    public function render()
    {
        return view('livewire.client.profile');
    }
}
