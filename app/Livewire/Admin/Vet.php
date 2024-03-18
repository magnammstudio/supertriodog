<?php

namespace App\Livewire\Admin;

use App\Models\client as ClientModels;
use App\Models\vet as VetModels;
use App\Models\stock;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Vet extends Component
{
    use WithPagination;
    use Actions;
    public $vet,$stock;
    public $stock_adj;
    public $rmkt=false;

    public function mount($id=null){
        if(!$id){
            return redirect()->route('admin.vets');
        }
        $this->vet = VetModels::find($id);
        if(!$this->vet){
            abort(404);
        }
        if(!Auth::user()->isAdmin){
            if(!Str::startsWith(Auth::user()->id, $this->vet->stock_id)){
                abort(403);
            }
        }
        
        $this->stock = $this->vet->stock;
    }
    public function render()
    {
        return view('livewire.admin.vet',[
            'vetClients'=>ClientModels::where('vet_id',$this->vet->id)->orderBy('updated_at','desc')->paginate(50)
        ])->extends('layouts.admin');
    }
    public function toggleRmkt(){
        $this->rmkt=!$this->rmkt;
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
        
        $this->notification()->success(
            $title = 'เติมสิทธิ์สมบูรณ์',
            $description = 'เพิ่มสิทธิ์จำนวน '.$this->stock_adj.' จำนวนสิทธิ์ทั้งหมด '.$vetStock->total_stock
        );
        $this->stock_adj=null;
        $this->stock = $vetStock;
    }
    public function delete (ClientModels $client){
        $client->delete();
    }
}
