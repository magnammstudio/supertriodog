<?php

namespace App\Livewire\Admin;

use App\Models\client as ClientModels;
use App\Models\stock;
use App\Models\vet as VetModels;
use Livewire\Component;

use Livewire\WithPagination;

class Vet extends Component
{
    use WithPagination;

    public $vet,$stock;
    public $stock_adj;
    // public $vetClients;

    public function mount($id){
        $this->vet = VetModels::find($id);
        $this->stock = $this->vet->withCurrentStock();
        // dd(VetModels::find(6783490232)->withCurrentStock()->sum('client_all'));
        // $this->vetClients = ClientModels::where('vet_id',$id)->get();
        // dd($this->vetClient->count());
    }
    public function render()
    {
        // dd(ClientModels::where('vet_id',$this->vet->id)->paginate(10));
        return view('livewire.admin.vet',[
            'vetClients'=>ClientModels::where('vet_id',$this->vet->id)->orderBy('updated_at','desc')->paginate(50)
        ])->extends('layouts.admin');
    }
    public function add_stock_adj(){
        $validatedData = $this->validate([
            'stock_adj'=>['required'],
        ]);
        $vetStock=stock::find($this->vet->stock_id);
        $vetStock->total_stock+=$this->stock_adj;
        $vetStock->stock_adj+=1;
        $vetStock->save();

        $this->stock = $this->vet->withCurrentStock();
        
    }
}
