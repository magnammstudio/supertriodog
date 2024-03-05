<?php

namespace App\Livewire\Management;

use App\Models\stock;
use App\Models\User;
use App\Models\vet;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use WireUi\Traits\Actions;
class VetEdit extends Component
{
    use Actions;

    public $user;
    public $stock;
    public vet $vet;
    public $data;

    protected $rules = [
        'vet.id' => 'required|string',
        'vet.vet_name' => 'required|string|max:500',
    ];
    public function mount($vet=null){
        // dd($this->vet,$vet);
        // $this->vet = vet::find($vet);
        // dd($this->vet);
        if($vet){
            $this->data=[
                'id'=>$vet->id,
                'vet_name'=>$vet->vet_name,
                'vet_province'=>$vet->vet_province,
                'vet_city'=>$vet->vet_city,
                'vet_area'=>$vet->vet_area,
                'user_id'=>$vet->user_id,
                'stock_id'=>$vet->stock_id,
            ];
            if(!$this->vet->stock){
                $stock = stock::create([
                    'id'=>$this->data['stock_id']??$this->data['id'],
                    'total_stock'=>0,
                    'stock_adj'=>0,
                ]);
            }

        }else{
            $this->vet= new vet();
            $this->data=[
                'id'=>null,
                'vet_name'=>null,
                'vet_province'=>null,
                'vet_city'=>null,
                'vet_area'=>null,
                'user_id'=>null,
                'stock_id'=>null,
            ];
        }
    }
    public function render()
    {
        // dd($this->vet);
        if($this->vet->user){
            $this->data['user_id']= $this->vet->user->id;
            $this->data['user_name']= $this->vet->user->name;
            $this->data['user_isAdmin']= $this->vet->user->isAdmin;
            // $this->data['user_password']= '';
        }
        if($this->vet->stock){
            $this->data['total_stock']= $this->vet->stock->total_stock;
            $this->data['stock_adj']= $this->vet->stock->stock_adj;
        }
        // dd($this->vet);
        return view('livewire.management.vet-edit')->extends('layouts.admin');
    }
    public function saveVet(){
        $validate = $this->validate([
            'data.id'=>['required'],
            'data.vet_name'=>['required'],
            'data.vet_province'=>['required'],
            'data.vet_city'=>['required'],
            'data.vet_area'=>['required'],
            'data.stock_id'=>['required'],
            'data.user_id'=>['nullable','exists:users,id'],
        ]);
        $data = $validate['data'];
        // dd($data);
        $vet = vet::updateOrCreate([
            'id'=>$data['id']
        ],[
            'vet_name'=>$data['vet_name'],
            'vet_province'=>$data['vet_province'],
            'vet_city'=>$data['vet_city'],
            'vet_area'=>$data['vet_area'],
            'user_id'=>$data['user_id']??null,
            'stock_id'=>$data['stock_id']
        ]);
        
        $this->notification()->success(
            $title = 'Vet Data Save',
            $description = $vet->id.' : '.$vet->vet_name
        );
    }
    
    public function saveStock(){
        $validate = $this->validate([
            'data.stock_adj'=>['required'],
            'data.total_stock'=>['required'],
            'data.stock_id'=>['required'],
        ]);

        $data = $validate['data'];
        
        $stock= stock::updateOrCreate([
            'id'=>$data['stock_id']
        ],[
            'total_stock'=>$data['total_stock'],
            'stock_adj'=>$data['stock_adj'],
        ]);

        $this->notification()->success(
            $title = 'Stock Data Save',
            $description = $stock->id.' : '.$stock->total_stock
        );
    }

    public function save(){
        dd($this->data);
    }

    public function createUser(){

        $validate = $this->validate([
            'data.id'=>['required'],
            'data.vet_name'=>['required'],
            'data.stock_id'=>['required','exists:stocks,id'],
        ]);

        $user = User::create([
            'id'=>$this->data['id'],
            'name'=>$this->data['vet_name'],
            'email'=>$this->data['stock_id'],
            'password'=>Hash::make($this->data['id']),
            'isAdmin'=>0,
        ]);
        $vet = vet::find($this->data['id']);
        $vet->user_id=$this->data['id'];
        $vet->save();

        dd(vet::find($this->data['id'])->user_id);
    }
}
