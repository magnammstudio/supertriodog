<?php

namespace App\Livewire\Admin;

use App\Models\rmktClient as ModelsRmktClient;
use Livewire\Component;

class RmktClient extends Component
{
    public $clients;
    public $vet;
    public function mount($id=null){
        $this->clients = ModelsRmktClient::all();

        // dd($this->clients[0],$this->clients[0]->profile);
    }
    public function render()
    {
        return view('livewire.admin.rmkt-client',[
            'clients' => ModelsRmktClient::all()
        ])->extends('layouts.admin');;
    }
}
