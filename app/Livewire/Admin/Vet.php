<?php

namespace App\Livewire\Admin;

use App\Models\client as ClientModels;
use App\Models\stock;
use App\Models\vet as VetModels;
use Hamcrest\Type\IsBoolean;
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
            return redirect()->route('admin.vets');
        }
        $this->vet = VetModels::find($id);
        if(!$this->vet){
            abort(404);
        }
        if(Auth::user()->isVet()){
            $isOwner = $this->vet->id == Auth::user()->id;
            if(!$isOwner){
                abort(403);
            }
        }
        $this->stock = $this->vet->withCurrentStock();
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
