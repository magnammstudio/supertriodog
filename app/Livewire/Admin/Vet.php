<?php

namespace App\Livewire\Admin;

use App\Models\client as ClientModels;
use App\Models\stock;
use App\Models\vet as VetModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

use Livewire\WithPagination;

class Vet extends Component
{
    use WithPagination;

    public $vet,$stock;
    public $stock_adj;
    // public $vetClients;

    public function mount($id=null){
        if(!$id){
            return redirect()->route('admin.vet',['id'=>Auth::user()->email]);
        }
        $this->vet = VetModels::find($id);
        if(!$this->vet){
            abort(404);
        }
        $isOwner = ($this->vet->id == Auth::user()->email)||($this->vet->stock_id == Auth::user()->name);
        if(! ($isOwner ||  Gate::allows('isAdmin', Auth::user()) )){
            abort(403);
        }
        $this->stock = $this->vet->withCurrentStock();
        // dd(VetModels::find(6783490232)->withCurrentStock()->sum('client_all'));
        // $this->vetClients = ClientModels::where('vet_id',$id)->get();
        // dd($this->vetClient->count());
    }
    public function render()
    {
        return view('livewire.admin.vet',[
            'vetClients'=>ClientModels::where('vet_id',$this->vet->id)->orderBy('updated_at','desc')->paginate(50)
        ])->extends('layouts.admin');
    }
    public function add_stock_adj(){
        $validatedData = $this->validate([
            'stock_adj'=>['required','numeric'],
        ],[
            'stock_adj.*'=>'กรุณาระบุ'
        ]);
        $vetStock=stock::find($this->vet->stock_id);
        $vetStock->total_stock+=$this->stock_adj;
        $vetStock->stock_adj+=1;
        $vetStock->save();

        $this->stock = $this->vet->withCurrentStock();
        
    }
    public function delete (ClientModels $client){
        $client->delete();
    }
}
