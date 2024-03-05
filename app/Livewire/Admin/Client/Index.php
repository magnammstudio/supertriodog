<?php

namespace App\Livewire\Admin\Client;

use App\Models\client;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        // dd(client::all()[0]->profile());
        return view('livewire.admin.client.index',[
            'clients'=>client::all()
        ])->extends('layouts.admin');;
    }
}
