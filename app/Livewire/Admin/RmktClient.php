<?php

namespace App\Livewire\Admin;

use App\Models\rmktClient as ModelsRmktClient;
use Livewire\Component;

class RmktClient extends Component
{
    public $clients;
    public $vet;
    public function mount($id=null){
        if($id){
            $this->clients = ModelsRmktClient::where('vet_id',$id)->get();
            $this->vet=$id;
        }else{
            $this->clients = ModelsRmktClient::all();
        }
        // dd($this->clients,$id);
    }
    public function render()
    {
        return view('livewire.admin.rmkt-client',[
            // 'clients' => ModelsRmktClient::all()
        ])->extends('layouts.admin');;
    }
}
